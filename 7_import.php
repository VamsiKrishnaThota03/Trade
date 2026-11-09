<?php
require __DIR__ . '/includes/bootstrap.php';
require __DIR__ . '/includes/trade.php';
require_login();

$title  = 'Import';
$active = 'import';
require __DIR__ . '/includes/header.php';
?>
<main class="container">
    <div class="page-head">
        <p class="eyebrow">Step 1 of 3</p>
        <h1>Import goods</h1>
        <p class="muted"><?= e(flow('import')['intro']) ?></p>
    </div>
    <?php render_search_form('import'); ?>
</main>
<?php require __DIR__ . '/includes/footer.php';
