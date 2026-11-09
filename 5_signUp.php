<?php
require __DIR__ . '/includes/bootstrap.php';

if (is_logged_in()) {
    redirect('6_trade.php');
}

$fields = ['uname' => '', 'email' => '', 'uage' => '', 'usex' => '', 'uphone' => '',
           'ucity' => '', 'country' => '', 'upincode' => ''];
$errors = [];

if (is_post()) {
    verify_csrf();
    foreach (array_keys($fields) as $key) {
        $fields[$key] = post_str($key, $key === 'email' ? 190 : 100);
    }
    $password  = (string) ($_POST['password'] ?? '');
    $cpassword = (string) ($_POST['cpassword'] ?? '');

    if ($fields['uname'] === '') {
        $errors[] = 'Name is required.';
    }
    if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    }
    $age = filter_var($fields['uage'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 18, 'max_range' => 120]]);
    if ($age === false) {
        $errors[] = 'Age must be a number between 18 and 120.';
    }
    if (!in_array($fields['usex'], ['male', 'female', 'other'], true)) {
        $errors[] = 'Select your sex.';
    }
    if (!preg_match('/^[0-9+\- ]{6,20}$/', $fields['uphone'])) {
        $errors[] = 'Enter a valid mobile number.';
    }
    if ($fields['ucity'] === '' || $fields['country'] === '') {
        $errors[] = 'City and country are required.';
    }
    if (!preg_match('/^[0-9A-Za-z \-]{3,10}$/', $fields['upincode'])) {
        $errors[] = 'Enter a valid pincode.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    } elseif (!hash_equals($password, $cpassword)) {
        $errors[] = 'Password and confirm password do not match.';
    }

    if (!$errors) {
        if (find_user($fields['email'])) {
            $errors[] = 'An account with that email already exists. Log in instead.';
        } else {
            $stmt = db()->prepare(
                'INSERT INTO user (email, uname, uage, usex, password, ucity, upincode, uphone, country)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
            );
            try {
                $stmt->execute([
                    $fields['email'], $fields['uname'], $age, $fields['usex'],
                    password_hash($password, PASSWORD_DEFAULT),
                    $fields['ucity'], $fields['upincode'], $fields['uphone'], $fields['country'],
                ]);
                flash('success', 'Your trader account is ready. Please log in.');
                redirect('4_login.php');
            } catch (PDOException $ex) {
                error_log('Trade: sign up failed: ' . $ex->getMessage());
                $errors[] = 'We could not create your account. Please try again.';
            }
        }
    }
}

$title  = 'Sign up';
$active = 'signup';
require __DIR__ . '/includes/header.php';
?>
<main class="container auth">
    <form class="card form auth-card wide" action="5_signUp.php" method="POST">
        <?= csrf_field() ?>
        <h1>Create a trader account</h1>
        <p class="muted">Register to list goods and place import or export requests.</p>
        <?php if ($errors): ?>
            <div class="alert alert-error" role="alert">
                <ul><?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul>
            </div>
        <?php endif; ?>
        <div class="form-grid">
            <div class="field">
                <label for="uname">Full name</label>
                <input id="uname" name="uname" type="text" autocomplete="name" required maxlength="100" value="<?= e($fields['uname']) ?>">
            </div>
            <div class="field">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" autocomplete="email" required maxlength="190" value="<?= e($fields['email']) ?>">
            </div>
            <div class="field">
                <label for="uage">Age</label>
                <input id="uage" name="uage" type="number" min="18" max="120" required value="<?= e($fields['uage']) ?>">
            </div>
            <fieldset class="field">
                <legend>Sex</legend>
                <div class="radio-row">
                    <?php foreach (['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $val => $label): ?>
                        <label class="radio">
                            <input type="radio" name="usex" value="<?= $val ?>" required<?= $fields['usex'] === $val ? ' checked' : '' ?>>
                            <?= $label ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </fieldset>
            <div class="field">
                <label for="uphone">Mobile number</label>
                <input id="uphone" name="uphone" type="tel" autocomplete="tel" required maxlength="20" value="<?= e($fields['uphone']) ?>">
            </div>
            <div class="field">
                <label for="ucity">City</label>
                <input id="ucity" name="ucity" type="text" autocomplete="address-level2" required maxlength="100" value="<?= e($fields['ucity']) ?>">
            </div>
            <div class="field">
                <label for="country">Country</label>
                <input id="country" name="country" type="text" autocomplete="country-name" required maxlength="100" value="<?= e($fields['country']) ?>">
            </div>
            <div class="field">
                <label for="upincode">Pincode</label>
                <input id="upincode" name="upincode" type="text" inputmode="numeric" autocomplete="postal-code" required maxlength="10" value="<?= e($fields['upincode']) ?>">
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" autocomplete="new-password" minlength="8" required>
                <p class="hint">At least 8 characters.</p>
            </div>
            <div class="field">
                <label for="cpassword">Confirm password</label>
                <input id="cpassword" name="cpassword" type="password" autocomplete="new-password" minlength="8" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Create account</button>
        <p class="auth-alt">Already registered? <a href="4_login.php">Log in</a></p>
    </form>
</main>
<?php require __DIR__ . '/includes/footer.php';
