<?php
require __DIR__ . '/includes/bootstrap.php';
require __DIR__ . '/includes/trade.php';
$user    = require_login();
$listing = listing_from_query('export');

$title  = 'Export details';
$active = 'export';
require __DIR__ . '/includes/header.php';
?>
<main class="container">
    <div class="page-head">
        <p class="eyebrow">Step 3 of 3</p>
        <h1>Export details</h1>
        <p class="muted">Enter your contact details and where the goods are going.</p>
    </div>
    <?php render_details_form('export', $listing, $user); ?>
</main>
<?php require __DIR__ . '/includes/footer.php';
