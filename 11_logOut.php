<?php
require __DIR__ . '/includes/bootstrap.php';

// Log out only via POST with a valid CSRF token, so other sites cannot log users out.
if (!is_post()) {
    redirect(is_logged_in() ? '6_trade.php' : '1_main_page.php');
}
verify_csrf();

$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}
session_destroy();

redirect('1_main_page.php');
