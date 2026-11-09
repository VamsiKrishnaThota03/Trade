<?php
require __DIR__ . '/includes/bootstrap.php';
require __DIR__ . '/includes/trade.php';
require_login();

$title  = 'Export';
$active = 'export';
require __DIR__ . '/includes/header.php';
?>
<main class="container">
    <div class="page-head">
        <p class="eyebrow">Step 1 of 3</p>
        <h1>Export goods</h1>
        <p class="muted"><?= e(flow('export')['intro']) ?>
            Not listed yet? <a href="10_add_items.php">Add your item</a> first.</p>
    </div>
    <?php render_search_form('export'); ?>
</main>
<?php require __DIR__ . '/includes/footer.php';
