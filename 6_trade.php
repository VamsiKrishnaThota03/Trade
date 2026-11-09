<?php
require __DIR__ . '/includes/bootstrap.php';
$user = require_login();

$pdo = db();
$count = static function (string $sql, array $params = []) use ($pdo): int {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return (int) $stmt->fetchColumn();
};
$stats = [
    ['Listings in stock', $count('SELECT COUNT(*) FROM available WHERE qty > 0')],
    ['Your listings', $count('SELECT COUNT(*) FROM available WHERE email = ?', [$user['email']])],
    ['Your trades', $count('SELECT COUNT(*) FROM total_table WHERE email = ?', [$user['email']])],
];

$title  = 'Dashboard';
$active = 'dash';
require __DIR__ . '/includes/header.php';
?>
<main class="container">
    <div class="page-head">
        <p class="eyebrow">Dashboard</p>
        <h1>Welcome, <?= e($user['uname']) ?></h1>
        <p class="muted">What would you like to trade today?</p>
    </div>

    <div class="stats">
        <?php foreach ($stats as [$label, $value]): ?>
            <div class="card stat"><span class="stat-value"><?= e($value) ?></span><span class="stat-label"><?= e($label) ?></span></div>
        <?php endforeach; ?>
    </div>

    <div class="actions-grid">
        <a class="card action-card" href="7_import.php">
            <span class="action-icon" aria-hidden="true">&#8601;</span>
            <h2>Import</h2>
            <p class="muted">Search listings by product type and request a quantity.</p>
        </a>
        <a class="card action-card" href="12_export.php">
            <span class="action-icon" aria-hidden="true">&#8599;</span>
            <h2>Export</h2>
            <p class="muted">Find a listing by type and name and submit export details.</p>
        </a>
        <a class="card action-card" href="10_add_items.php">
            <span class="action-icon" aria-hidden="true">+</span>
            <h2>Add items</h2>
            <p class="muted">List your goods with type, origin, quantity and price.</p>
        </a>
        <a class="card action-card" href="16_invoice.php">
            <span class="action-icon" aria-hidden="true">&#9776;</span>
            <h2>My trades</h2>
            <p class="muted">Review every import and export request you have placed.</p>
        </a>
    </div>

    <section class="section">
        <h2 class="section-title">Market trends</h2>
        <p class="muted">Static reference charts of prices and trade volumes (illustrations, not live data).</p>
        <div class="charts">
            <figure class="card chart"><img src="linechart1.png" alt="Line chart of monthly prices of paddy, ragi and maize" loading="lazy"></figure>
            <figure class="card chart"><img src="linechart2.png" alt="Samsung Electronics sales and profit by segment, 2011 to 2021" loading="lazy"></figure>
            <figure class="card chart"><img src="chart3.png" alt="Bar chart of annual sales volume in million metric tons" loading="lazy"></figure>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php';
