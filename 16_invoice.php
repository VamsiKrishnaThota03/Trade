<?php
require __DIR__ . '/includes/bootstrap.php';
$user = require_login();

$stmt = db()->prepare(
    'SELECT id, pid, ptype, pname, trade_type, qty, price, created_at
       FROM total_table WHERE email = ? ORDER BY id DESC'
);
$stmt->execute([$user['email']]);
$trades = $stmt->fetchAll();

$total = 0.0;
foreach ($trades as $t) {
    $total += (float) $t['price'] * (int) $t['qty'];
}

$title  = 'My trades';
$active = 'trades';
require __DIR__ . '/includes/header.php';
?>
<main class="container">
    <div class="page-head">
        <h1>My trades</h1>
        <p class="muted">Every import and export request placed from your account.</p>
    </div>
    <?php if (!$trades): ?>
        <div class="card empty-state">
            <h2>No trades yet</h2>
            <p class="muted">When you place an import or export request it will appear here.</p>
            <div class="btn-row">
                <a class="btn btn-primary" href="7_import.php">Start an import</a>
                <a class="btn btn-secondary" href="12_export.php">Start an export</a>
            </div>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="table-wrap">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Trade</th>
                        <th scope="col">Type</th>
                        <th scope="col">Product</th>
                        <th scope="col" class="num">Qty</th>
                        <th scope="col" class="num">Unit price</th>
                        <th scope="col" class="num">Total</th>
                        <th scope="col">Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($trades as $t): ?>
                        <tr>
                            <td data-label="Trade">#<?= e($t['id']) ?></td>
                            <td data-label="Type"><span class="badge badge-<?= e($t['trade_type']) ?>"><?= e(ucfirst($t['trade_type'])) ?></span></td>
                            <td data-label="Product"><span class="cell-stack"><strong><?= e($t['pname']) ?></strong><span class="muted"><?= e($t['ptype']) ?> · listing #<?= e($t['pid']) ?></span></span></td>
                            <td data-label="Qty" class="num"><?= e($t['qty']) ?></td>
                            <td data-label="Unit price" class="num"><?= e(money($t['price'])) ?></td>
                            <td data-label="Total" class="num"><strong><?= e(money((float) $t['price'] * (int) $t['qty'])) ?></strong></td>
                            <td data-label="Date"><?= e(date('d M Y', strtotime((string) $t['created_at']))) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr><td colspan="5">Total value</td><td class="num"><strong><?= e(money($total)) ?></strong></td><td></td></tr>
                    </tfoot>
                </table>
            </div>
        </div>
    <?php endif; ?>
</main>
<?php require __DIR__ . '/includes/footer.php';
