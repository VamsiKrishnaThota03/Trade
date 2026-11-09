<?php
require __DIR__ . '/includes/bootstrap.php';
require __DIR__ . '/includes/trade.php';
require_login();

$ptype = mb_substr(trim((string) ($_GET['ptype'] ?? '')), 0, 100);
if ($ptype === '') {
    flash('error', 'Enter a product type to search for.');
    redirect('7_import.php');
}
$rows = search_listings($ptype);

$title  = 'Import listings';
$active = 'import';
require __DIR__ . '/includes/header.php';
?>
<main class="container">
    <div class="page-head">
        <p class="eyebrow">Step 2 of 3</p>
        <h1>Choose a listing to import</h1>
    </div>
    <?php render_search_form('import', $ptype); ?>
    <?php render_results('import', $rows, $ptype); ?>
</main>
<?php require __DIR__ . '/includes/footer.php';
