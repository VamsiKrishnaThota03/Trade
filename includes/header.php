<?php
/**
 * Page header and navigation. Expects $title (string) and optionally
 * $active (string) to highlight the current nav item.
 */
defined('TRADE_APP') || exit;

$title  = $title ?? 'Trade';
$active = $active ?? '';
$user   = current_user();

$nav = $user
    ? [
        'home'   => ['1_main_page.php', 'Home'],
        'dash'   => ['6_trade.php', 'Dashboard'],
        'import' => ['7_import.php', 'Import'],
        'export' => ['12_export.php', 'Export'],
        'add'    => ['10_add_items.php', 'Add items'],
        'trades' => ['16_invoice.php', 'My trades'],
    ]
    : [
        'home'   => ['1_main_page.php', 'Home'],
        'about'  => ['1_main_page.php#about', 'About'],
        'login'  => ['4_login.php', 'Log in'],
    ];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?> · Trade</title>
    <meta name="description" content="Trade: list goods and place import or export requests.">
    <link rel="icon" href="favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="2_style.css">
</head>
<body>
<a class="skip-link" href="#content">Skip to content</a>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="<?= $user ? '6_trade.php' : '1_main_page.php' ?>" aria-label="Trade home">
            <svg class="brand-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="1.8"/>
                <path d="M2 12h20M12 2c3 3.2 3 16.8 0 20M12 2c-3 3.2-3 16.8 0 20" fill="none" stroke="currentColor" stroke-width="1.8"/>
            </svg>
            <span>Trade</span>
        </a>
        <input type="checkbox" id="nav-toggle" class="nav-toggle" aria-label="Toggle navigation">
        <label for="nav-toggle" class="nav-toggle-label" aria-hidden="true"><span></span></label>
        <nav class="site-nav" aria-label="Main">
            <ul>
                <?php foreach ($nav as $key => [$href, $label]): ?>
                    <li><a href="<?= e($href) ?>"<?= $key === $active ? ' aria-current="page"' : '' ?>><?= e($label) ?></a></li>
                <?php endforeach; ?>
                <?php if ($user): ?>
                    <li class="nav-user">
                        <form action="11_logOut.php" method="POST">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-ghost btn-sm">Log out</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li><a class="btn btn-accent btn-sm" href="5_signUp.php">Sign up</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<div id="content" class="page">
<?php $flashes = take_flashes(); if ($flashes): ?>
    <div class="container flashes" role="status" aria-live="polite">
        <?php foreach ($flashes as $f): ?>
            <div class="alert alert-<?= e($f['type']) ?>"><?= e($f['message']) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
