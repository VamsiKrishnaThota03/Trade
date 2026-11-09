<?php
require __DIR__ . '/includes/bootstrap.php';

$title  = 'Import & export marketplace';
$active = 'home';
$loggedIn = is_logged_in();
require __DIR__ . '/includes/header.php';
?>
<main>
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-copy">
                <p class="eyebrow">Importer Exporter Code (IEC)</p>
                <h1>Trade goods across borders, simply.</h1>
                <p class="lead">List your products, discover goods from other traders and place import or
                    export requests in a few steps.</p>
                <div class="btn-row">
                    <?php if ($loggedIn): ?>
                        <a class="btn btn-primary" href="6_trade.php">Go to dashboard</a>
                    <?php else: ?>
                        <a class="btn btn-primary" href="5_signUp.php">Create an account</a>
                        <a class="btn btn-secondary" href="4_login.php">Log in</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="hero-media">
                <img src="pic.jpg" alt="Aerial view of a container port with stacked shipping containers" width="1280" height="719">
            </div>
        </div>
    </section>

    <div class="container landing-grid">
        <section class="card">
            <h2>Register for your IEC</h2>
            <p>The Importer-Exporter Code (IEC) is a key business identification number which is mandatory for
                exports or imports. No person shall make any import or export except under an IEC number granted
                by the DGFT. For import or export of services or technology, the IEC is required only when the
                service or technology provider is taking benefits under the Foreign Trade Policy or is dealing with
                specified services or technologies.</p>
            <p class="muted">An IEC may be obtained by a proprietorship, partnership, LLP, limited company, trust,
                HUF or society. Since GST was introduced, the IEC number is the same as the PAN of the firm, but it is
                still issued separately by the DGFT.</p>
            <div class="btn-row">
                <a class="btn btn-secondary" href="https://www.dgft.gov.in/CP/complaintssuggestion" target="_blank" rel="noopener">IEC help &amp; FAQs</a>
                <a class="btn btn-primary" href="https://www.dgft.gov.in/CP/" target="_blank" rel="noopener">Apply for IEC</a>
            </div>
        </section>

        <form class="card chooser" action="4_login.php" method="GET">
            <h2>Are you an importer or an exporter?</h2>
            <p class="muted">Pick one to jump straight into the right flow.</p>
            <div class="choice-row">
                <label class="choice">
                    <input type="radio" name="next" value="7_import.php" required>
                    <span><strong>Importer</strong><small>Buy goods listed by other traders</small></span>
                </label>
                <label class="choice">
                    <input type="radio" name="next" value="12_export.php">
                    <span><strong>Exporter</strong><small>Send goods to another country</small></span>
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Discover</button>
        </form>
    </div>

    <section class="services-band">
        <div class="container">
            <h2 class="section-title">Services</h2>
            <div class="services-grid">
                <?php
                $services = [
                    ['Importer Exporter Code (IEC)', 'A key business identification number, mandatory for export from India or import to India. Explore the IEC services offered by DGFT.'],
                    ['Import Management System', 'Import licences for restricted items, Steel Import Monitoring System (SIMS), Tariff Rate Quota (TRQ) licences and registration certificates.'],
                    ['Export Management System', 'Export licences for restricted items, SCOMET items, licences under the Indo-US memorandum and Indo-EU arrangements, and more.'],
                    ['EPCG', 'The Export Promotion Capital Goods scheme facilitates import of capital goods for producing quality goods and services.'],
                ];
                foreach ($services as [$name, $text]): ?>
                    <article class="service">
                        <h3><?= e($name) ?></h3>
                        <p><?= e($text) ?></p>
                        <a href="https://www.dgft.gov.in/CP/" target="_blank" rel="noopener">View more <span aria-hidden="true">&rarr;</span></a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="about" class="container section about">
        <h2 class="section-title">About</h2>
        <p>Trade is a DBMS course project from IIITDM Jabalpur. Registered traders list goods with their type, origin,
            quantity and price, and other traders place import or export requests against those listings. Each request
            reduces the available stock and is recorded in the trader's history.</p>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php';
