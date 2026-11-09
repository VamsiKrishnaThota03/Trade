<?php
require __DIR__ . '/includes/bootstrap.php';
require __DIR__ . '/includes/trade.php';
$user    = require_login();
$listing = listing_from_query('import');

$title  = 'Import details';
$active = 'import';
require __DIR__ . '/includes/header.php';
?>
<main class="container">
    <div class="page-head">
        <p class="eyebrow">Step 3 of 3</p>
        <h1>Import details</h1>
        <p class="muted">Tell us where the goods should be delivered.</p>
    </div>
    <?php render_details_form('import', $listing, $user); ?>
</main>
<?php require __DIR__ . '/includes/footer.php';
