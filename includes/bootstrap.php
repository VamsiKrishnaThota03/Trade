<?php
/**
 * Shared bootstrap: configuration, session, database and small helpers.
 * Every page includes this file first.
 */

declare(strict_types=1);

define('TRADE_APP', true);
define('APP_ROOT', dirname(__DIR__));

/* ------------------------------------------------------------------ config */

/**
 * Load KEY=VALUE pairs from a local .env file (if present) without
 * overriding variables that are already set in the real environment.
 */
function load_env_file(string $path): void
{
    if (!is_readable($path)) {
        return;
    }
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = array_map('trim', explode('=', $line, 2));
        if (strlen($value) >= 2 && ($value[0] === '"' || $value[0] === "'") && $value[-1] === $value[0]) {
            $value = substr($value, 1, -1);
        }
        if ($key !== '' && getenv($key) === false) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

load_env_file(APP_ROOT . '/.env');

function env(string $key, ?string $default = null): ?string
{
    $value = getenv($key);
    return $value === false ? $default : $value;
}

define('APP_DEBUG', filter_var(env('APP_DEBUG', 'false'), FILTER_VALIDATE_BOOLEAN));

ini_set('display_errors', APP_DEBUG ? '1' : '0');
error_reporting(E_ALL);

/* ----------------------------------------------------------------- session */

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_name('trade_session');
    session_start();
}

/* ---------------------------------------------------------------- database */

/**
 * Lazily create a PDO connection. Defaults match a local XAMPP/MAMP install
 * (MySQL root user without a password). Set DB_* variables for anything else.
 * DB_DSN, when set, overrides the host/port/name settings entirely.
 */
function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = env('DB_DSN');
    if ($dsn === null || $dsn === '') {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            env('DB_HOST', 'localhost'),
            env('DB_PORT', '3306'),
            env('DB_NAME', 'project')
        );
    }

    try {
        $pdo = new PDO($dsn, env('DB_USER', 'root'), env('DB_PASS', ''), [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    } catch (PDOException $ex) {
        error_log('Trade: database connection failed: ' . $ex->getMessage());
        http_response_code(500);
        $title = 'Database unavailable';
        require APP_ROOT . '/includes/header.php';
        echo '<main class="container narrow"><div class="card"><h1>Database unavailable</h1>'
            . '<p class="muted">The application could not connect to its database. '
            . 'Check the <code>DB_*</code> settings in <code>.env</code> and that MySQL is running, '
            . 'then import <code>schema.sql</code>.</p></div></main>';
        require APP_ROOT . '/includes/footer.php';
        exit;
    }

    if (str_starts_with($dsn, 'sqlite:')) {
        $pdo->exec('PRAGMA foreign_keys = ON');
    }

    return $pdo;
}

/* ----------------------------------------------------------------- helpers */

/** Escape a value for HTML output. */
function e(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $location): never
{
    header('Location: ' . $location);
    exit;
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

/** @return list<array{type:string,message:string}> */
function take_flashes(): array
{
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool
{
    return current_user() !== null;
}

/** Send anonymous visitors to the login page, remembering where they wanted to go. */
function require_login(): array
{
    $user = current_user();
    if ($user === null) {
        $target = basename(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '6_trade.php');
        flash('info', 'Please log in to continue.');
        redirect('4_login.php?next=' . rawurlencode($target));
    }
    return $user;
}

/** Only allow redirects to local PHP pages of this app (prevents open redirects). */
function safe_next(?string $next, string $fallback = '6_trade.php'): string
{
    if ($next !== null && preg_match('/^[A-Za-z0-9_]+\.php$/', $next) && is_file(APP_ROOT . '/' . $next)) {
        return $next;
    }
    return $fallback;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">';
}

/** Abort POST requests that do not carry the session's CSRF token. */
function verify_csrf(): void
{
    $sent = $_POST['csrf'] ?? '';
    if (!is_string($sent) || !hash_equals(csrf_token(), $sent)) {
        http_response_code(400);
        flash('error', 'Your session expired. Please try again.');
        redirect(basename($_SERVER['PHP_SELF'] ?? '1_main_page.php'));
    }
}

function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

/** Read and trim a string field from POST. */
function post_str(string $key, int $maxLength = 255): string
{
    $value = $_POST[$key] ?? '';
    if (!is_string($value)) {
        return '';
    }
    return mb_substr(trim($value), 0, $maxLength);
}

function money(mixed $amount): string
{
    return number_format((float) $amount, 2);
}

/** Fetch a single listing by id, or null. */
function find_listing(int $pid): ?array
{
    $stmt = db()->prepare('SELECT pid, email, ptype, pname, country, qty, price FROM available WHERE pid = ?');
    $stmt->execute([$pid]);
    $row = $stmt->fetch();
    return $row === false ? null : $row;
}

/** Fetch the profile of a registered user, or null. */
function find_user(string $email): ?array
{
    $stmt = db()->prepare('SELECT email, uname, uage, usex, ucity, upincode, uphone, country FROM user WHERE email = ?');
    $stmt->execute([$email]);
    $row = $stmt->fetch();
    return $row === false ? null : $row;
}
