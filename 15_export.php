<?php
require __DIR__ . '/includes/bootstrap.php';
require __DIR__ . '/includes/trade.php';
require_login();

$ptype = mb_substr(trim((string) ($_GET['ptype'] ?? '')), 0, 100);
$pname = mb_substr(trim((string) ($_GET['pname'] ?? '')), 0, 100);
if ($ptype === '') {
    flash('error', 'Enter a product type to search for.');
    redirect('12_export.php');
}
$rows = search_listings($ptype, $pname);

$title  = 'Export listings';
$active = 'export';
require __DIR__ . '/includes/header.php';
?>
<main class="container">
    <div class="page-head">
        <p class="eyebrow">Step 2 of 3</p>
        <h1>Choose a listing to export</h1>
    </div>
    <?php render_search_form('export', $ptype, $pname); ?>
    <?php render_results('export', $rows, $ptype, $pname); ?>
</main>
<?php require __DIR__ . '/includes/footer.php';
