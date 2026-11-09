<?php
require __DIR__ . '/includes/bootstrap.php';
$user = require_login();

$fields = ['ptype' => '', 'pname' => '', 'country' => '', 'qty' => '', 'price' => ''];
$errors = [];

if (is_post()) {
    verify_csrf();
    foreach (array_keys($fields) as $key) {
        $fields[$key] = post_str($key, 100);
    }
    $qty   = filter_var($fields['qty'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $price = filter_var($fields['price'], FILTER_VALIDATE_FLOAT);

    if ($fields['ptype'] === '' || $fields['pname'] === '' || $fields['country'] === '') {
        $errors[] = 'Product type, name and country are required.';
    }
    if ($qty === false) {
        $errors[] = 'Quantity must be a whole number of at least 1.';
    }
    if ($price === false || $price <= 0 || $price >= 1e10) {
        $errors[] = 'Price must be a positive number.';
    }

    if (!$errors) {
        $stmt = db()->prepare(
            'INSERT INTO available (email, ptype, pname, country, qty, price) VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$user['email'], $fields['ptype'], $fields['pname'], $fields['country'], $qty, round($price, 2)]);
        flash('success', 'Your product "' . $fields['pname'] . '" was added to the catalogue.');
        redirect('10_add_items.php');
    }
}

$stmt = db()->prepare('SELECT pid, ptype, pname, country, qty, price FROM available WHERE email = ? ORDER BY pid DESC');
$stmt->execute([$user['email']]);
$mine = $stmt->fetchAll();

$title  = 'Add items';
$active = 'add';
require __DIR__ . '/includes/header.php';
?>
<main class="container">
    <div class="page-head">
        <h1>Add items</h1>
        <p class="muted">List goods so other traders can import or export them.</p>
    </div>
    <div class="grid-2">
        <form class="card form" action="10_add_items.php" method="POST">
            <?= csrf_field() ?>
            <h2>New listing</h2>
            <?php if ($errors): ?>
                <div class="alert alert-error" role="alert">
                    <ul><?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul>
                </div>
            <?php endif; ?>
            <div class="field">
                <label for="ptype">Product type</label>
                <input id="ptype" name="ptype" type="text" required maxlength="100" placeholder="e.g. Grain" value="<?= e($fields['ptype']) ?>">
            </div>
            <div class="field">
                <label for="pname">Product name</label>
                <input id="pname" name="pname" type="text" required maxlength="100" placeholder="e.g. Basmati rice" value="<?= e($fields['pname']) ?>">
            </div>
            <div class="field">
                <label for="country">Origin country</label>
                <input id="country" name="country" type="text" required maxlength="100" value="<?= e($fields['country']) ?>">
            </div>
            <div class="form-grid">
                <div class="field">
                    <label for="qty">Quantity</label>
                    <input id="qty" name="qty" type="number" min="1" step="1" required value="<?= e($fields['qty']) ?>">
                </div>
                <div class="field">
                    <label for="price">Unit price</label>
                    <input id="price" name="price" type="number" min="0.01" step="0.01" required value="<?= e($fields['price']) ?>">
                </div>
            </div>
            <p class="hint">Listed under <?= e($user['email']) ?>.</p>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Add item</button>
            </div>
        </form>

        <section class="card">
            <h2>Your listings</h2>
            <?php if (!$mine): ?>
                <div class="empty-state compact">
                    <p class="muted">You have not listed anything yet.</p>
                </div>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                        <tr><th scope="col">ID</th><th scope="col">Product</th><th scope="col">Origin</th>
                            <th scope="col" class="num">Price</th><th scope="col" class="num">Stock</th></tr>
                        </thead>
                        <tbody>
                        <?php foreach ($mine as $row): ?>
                            <tr>
                                <td data-label="ID">#<?= e($row['pid']) ?></td>
                                <td data-label="Product"><span class="cell-stack"><strong><?= e($row['pname']) ?></strong><span class="muted"><?= e($row['ptype']) ?></span></span></td>
                                <td data-label="Origin"><?= e($row['country']) ?></td>
                                <td data-label="Price" class="num"><?= e(money($row['price'])) ?></td>
                                <td data-label="Stock" class="num"><?= (int) $row['qty'] === 0 ? '<span class="badge badge-muted">Sold out</span>' : e($row['qty']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>
<?php require __DIR__ . '/includes/footer.php';
