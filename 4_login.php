<?php
require __DIR__ . '/includes/bootstrap.php';

$next = safe_next($_GET['next'] ?? $_POST['next'] ?? null);
if (is_logged_in()) {
    redirect($next);
}

$email = '';
$error = null;

if (is_post()) {
    verify_csrf();
    $email    = post_str('email', 190);
    $password = (string) ($_POST['password'] ?? '');

    $stmt = db()->prepare('SELECT email, uname, password FROM user WHERE email = ?');
    $stmt->execute([$email]);
    $row = $stmt->fetch();

    $valid = false;
    if ($row) {
        $stored = (string) $row['password'];
        if (password_get_info($stored)['algo'] !== null) {
            $valid = password_verify($password, $stored);
        } else {
            // Legacy account created before passwords were hashed: compare once,
            // then upgrade the stored value to a proper hash.
            $valid = $stored !== '' && hash_equals($stored, $password);
        }
        if ($valid && (password_get_info($stored)['algo'] === null || password_needs_rehash($stored, PASSWORD_DEFAULT))) {
            $upgrade = db()->prepare('UPDATE user SET password = ? WHERE email = ?');
            $upgrade->execute([password_hash($password, PASSWORD_DEFAULT), $row['email']]);
        }
    } else {
        // Spend comparable time when the account does not exist.
        password_verify($password, '$2y$12$z.RO5.tTC.qB1dEzsgSfw.rEbtRbQ/10uf6T4JhPUZ6dnHt7DOzEm');
    }

    if ($valid) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['email' => $row['email'], 'uname' => $row['uname']];
        flash('success', 'Welcome back, ' . $row['uname'] . '!');
        redirect($next);
    }
    $error = 'Incorrect email or password.';
}

$title  = 'Log in';
$active = 'login';
require __DIR__ . '/includes/header.php';
?>
<main class="container auth">
    <form class="card form auth-card" action="4_login.php" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="next" value="<?= e($next) ?>">
        <h1>Log in</h1>
        <p class="muted">Access your trading dashboard.</p>
        <?php if ($error): ?>
            <div class="alert alert-error" role="alert"><?= e($error) ?></div>
        <?php endif; ?>
        <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" autocomplete="email" required maxlength="190"
                   value="<?= e($email) ?>" autofocus>
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Log in</button>
        <p class="auth-alt">Not a member? <a href="5_signUp.php">Create an account</a></p>
    </form>
</main>
<?php require __DIR__ . '/includes/footer.php';
