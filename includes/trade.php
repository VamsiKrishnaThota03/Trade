<?php
/**
 * Shared logic for the import and export flows. Both flows work the same
 * way: search the listings, pick one, enter contact/shipping details and
 * submit. Submitting reduces the listing's stock and records the trade.
 */
defined('TRADE_APP') || exit;

const TRADE_FLOWS = [
    'import' => [
        'label'   => 'Import',
        'search'  => '7_import.php',
        'results' => '8_import.php',
        'details' => '9_import.php',
        'submit'  => '11_import.php',
        'table'   => 'import_data',
        'intro'   => 'Search the catalogue for goods you want to import.',
    ],
    'export' => [
        'label'   => 'Export',
        'search'  => '12_export.php',
        'results' => '15_export.php',
        'details' => '13_export.php',
        'submit'  => '14_export.php',
        'table'   => 'export_data',
        'intro'   => 'Find the listing you want to export by product type and name.',
    ],
];

function flow(string $type): array
{
    return TRADE_FLOWS[$type];
}

/** Escape LIKE wildcards so user input is matched literally. */
function like_term(string $term): string
{
    return '%' . strtr($term, ['!' => '!!', '%' => '!%', '_' => '!_']) . '%';
}

/**
 * Search listings with stock left. Type is required; name is optional.
 * @return list<array>
 */
function search_listings(string $ptype, string $pname = ''): array
{
    $sql = "SELECT pid, ptype, pname, country, qty, price FROM available
            WHERE qty > 0 AND ptype LIKE ? ESCAPE '!'";
    $params = [like_term($ptype)];
    if ($pname !== '') {
        $sql .= " AND pname LIKE ? ESCAPE '!'";
        $params[] = like_term($pname);
    }
    $sql .= ' ORDER BY ptype, pname, price';
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function render_search_form(string $type, string $ptype = '', string $pname = ''): void
{
    $f = flow($type);
    $withName = $type === 'export';
    ?>
    <form class="card search-card" action="<?= e($f['results']) ?>" method="GET" role="search">
        <div class="search-fields<?= $withName ? ' two' : '' ?>">
            <div class="field">
                <label for="ptype">Product type</label>
                <input id="ptype" name="ptype" type="text" required maxlength="100"
                       placeholder="e.g. Grain, Steel, Textiles" value="<?= e($ptype) ?>">
            </div>
            <?php if ($withName): ?>
                <div class="field">
                    <label for="pname">Product name <span class="muted">(optional)</span></label>
                    <input id="pname" name="pname" type="text" maxlength="100"
                           placeholder="e.g. Basmati rice" value="<?= e($pname) ?>">
                </div>
            <?php endif; ?>
            <div class="field field-action">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>
    <?php
}

/** @param list<array> $rows */
function render_results(string $type, array $rows, string $ptype, string $pname = ''): void
{
    $f = flow($type);
    $query = $pname !== '' ? "\u{201C}$ptype\u{201D} / \u{201C}$pname\u{201D}" : "\u{201C}$ptype\u{201D}";
    if (!$rows) {
        ?>
        <div class="card empty-state">
            <h2>No listings found</h2>
            <p class="muted">Nothing in stock matches <?= e($query) ?>. Try a broader search<?php
                if ($type === 'export'): ?>, or <a href="10_add_items.php">add your own item</a><?php endif; ?>.</p>
        </div>
        <?php
        return;
    }
    ?>
    <div class="card">
        <div class="card-head">
            <h2><?= count($rows) ?> listing<?= count($rows) === 1 ? '' : 's' ?> for <?= e($query) ?></h2>
        </div>
        <div class="table-wrap">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Type</th>
                    <th scope="col">Product</th>
                    <th scope="col">Origin</th>
                    <th scope="col" class="num">Price</th>
                    <th scope="col" class="num">In stock</th>
                    <th scope="col"><span class="sr-only">Action</span></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td data-label="ID">#<?= e($row['pid']) ?></td>
                        <td data-label="Type"><?= e($row['ptype']) ?></td>
                        <td data-label="Product"><strong><?= e($row['pname']) ?></strong></td>
                        <td data-label="Origin"><?= e($row['country']) ?></td>
                        <td data-label="Price" class="num"><?= e(money($row['price'])) ?></td>
                        <td data-label="In stock" class="num"><?= e($row['qty']) ?></td>
                        <td class="actions">
                            <a class="btn btn-primary btn-sm" href="<?= e($f['details']) ?>?pid=<?= (int) $row['pid'] ?>">
                                Select
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}

/** Render the contact and shipping details form for one listing. */
function render_details_form(string $type, array $listing, array $user): void
{
    $f   = flow($type);
    $old = $_SESSION['old_input'] ?? [];
    unset($_SESSION['old_input']);
    $profile = find_user($user['email']) ?? [];
    $value = static fn (string $key, ?string $fallback = '') => e($old[$key] ?? $fallback);
    ?>
    <div class="grid-2">
        <aside class="card listing-summary">
            <p class="eyebrow"><?= e($f['label']) ?> request</p>
            <h2><?= e($listing['pname']) ?></h2>
            <dl class="facts">
                <div><dt>Listing</dt><dd>#<?= e($listing['pid']) ?></dd></div>
                <div><dt>Type</dt><dd><?= e($listing['ptype']) ?></dd></div>
                <div><dt>Origin</dt><dd><?= e($listing['country']) ?></dd></div>
                <div><dt>Unit price</dt><dd><?= e(money($listing['price'])) ?></dd></div>
                <div><dt>In stock</dt><dd><?= e($listing['qty']) ?></dd></div>
            </dl>
            <a class="link-back" href="<?= e($f['search']) ?>">&larr; Choose a different listing</a>
        </aside>

        <form class="card form" action="<?= e($f['submit']) ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="pid" value="<?= (int) $listing['pid'] ?>">
            <h2>Your details</h2>
            <div class="form-grid">
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" required maxlength="190"
                           value="<?= $value('email', $user['email']) ?>">
                </div>
                <div class="field">
                    <label for="uname">Name</label>
                    <input id="uname" name="uname" type="text" required maxlength="100"
                           value="<?= $value('uname', $user['uname']) ?>">
                </div>
                <div class="field">
                    <label for="phone">Mobile number</label>
                    <input id="phone" name="phone" type="tel" required maxlength="20" pattern="[0-9+\- ]{6,20}"
                           value="<?= $value('phone', $profile['uphone'] ?? '') ?>">
                </div>
                <div class="field">
                    <label for="city">City</label>
                    <input id="city" name="city" type="text" required maxlength="100"
                           value="<?= $value('city', $profile['ucity'] ?? '') ?>">
                </div>
                <div class="field">
                    <label for="origin_country">Origin country</label>
                    <input id="origin_country" name="origin_country" type="text" required maxlength="100"
                           value="<?= $value('origin_country', $listing['country']) ?>">
                </div>
                <div class="field">
                    <label for="dest_country">Destination country</label>
                    <input id="dest_country" name="dest_country" type="text" required maxlength="100"
                           value="<?= $value('dest_country', $profile['country'] ?? '') ?>">
                </div>
                <div class="field">
                    <label for="qty">Quantity</label>
                    <input id="qty" name="qty" type="number" required min="1" max="<?= (int) $listing['qty'] ?>"
                           step="1" inputmode="numeric" value="<?= $value('qty', '1') ?>">
                    <p class="hint">Up to <?= e($listing['qty']) ?> available.</p>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Submit <?= e(strtolower($f['label'])) ?> request</button>
            </div>
        </form>
    </div>
    <?php
}

/** Load the listing referenced by ?pid= (or redirect back to the search page). */
function listing_from_query(string $type): array
{
    $pid = filter_input(INPUT_GET, 'pid', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $listing = $pid ? find_listing($pid) : null;
    if ($listing === null) {
        flash('error', 'That listing does not exist. Please pick one from the search results.');
        redirect(flow($type)['search']);
    }
    if ((int) $listing['qty'] < 1) {
        flash('error', 'That listing is out of stock.');
        redirect(flow($type)['search']);
    }
    return $listing;
}

/**
 * Validate and record a trade. Stock is decremented atomically and only if
 * enough is left, so two concurrent requests cannot oversell a listing.
 */
function process_trade(string $type): never
{
    $f    = flow($type);
    $user = require_login();
    if (!is_post()) {
        redirect($f['search']);
    }
    verify_csrf();

    $pid = filter_input(INPUT_POST, 'pid', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    $listing = $pid ? find_listing($pid) : null;
    if ($listing === null) {
        flash('error', 'That listing no longer exists.');
        redirect($f['search']);
    }

    $input = [
        'email'          => post_str('email', 190),
        'uname'          => post_str('uname', 100),
        'phone'          => post_str('phone', 20),
        'city'           => post_str('city', 100),
        'origin_country' => post_str('origin_country', 100),
        'dest_country'   => post_str('dest_country', 100),
        'qty'            => post_str('qty', 10),
    ];
    $qty = filter_var($input['qty'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

    $errors = [];
    foreach (['uname' => 'Name', 'city' => 'City', 'origin_country' => 'Origin country', 'dest_country' => 'Destination country'] as $key => $label) {
        if ($input[$key] === '') {
            $errors[] = "$label is required.";
        }
    }
    if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter a valid email address.';
    }
    if (!preg_match('/^[0-9+\- ]{6,20}$/', $input['phone'])) {
        $errors[] = 'Enter a valid mobile number.';
    }
    if ($qty === false) {
        $errors[] = 'Quantity must be a whole number of at least 1.';
    } elseif ($qty > (int) $listing['qty']) {
        $errors[] = 'Only ' . $listing['qty'] . ' units are available.';
    }

    $back = $f['details'] . '?pid=' . (int) $listing['pid'];
    if ($errors) {
        foreach ($errors as $error) {
            flash('error', $error);
        }
        $_SESSION['old_input'] = $input;
        redirect($back);
    }

    $pdo = db();
    try {
        $pdo->beginTransaction();

        $update = $pdo->prepare('UPDATE available SET qty = qty - ? WHERE pid = ? AND qty >= ?');
        $update->execute([$qty, $listing['pid'], $qty]);
        if ($update->rowCount() !== 1) {
            $pdo->rollBack();
            flash('error', 'Sorry, there is not enough stock left for that quantity.');
            $_SESSION['old_input'] = $input;
            redirect($back);
        }

        $insert = $pdo->prepare(
            "INSERT INTO {$f['table']}
                (email, uname, phone, city, origin_country, pid, ptype, pname, dest_country, qty, price)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $insert->execute([
            $input['email'], $input['uname'], $input['phone'], $input['city'], $input['origin_country'],
            $listing['pid'], $listing['ptype'], $listing['pname'], $input['dest_country'], $qty, $listing['price'],
        ]);

        // The trade log is keyed by the logged-in account so "My trades" can find it.
        $log = $pdo->prepare(
            'INSERT INTO total_table (email, uname, pid, ptype, pname, trade_type, qty, price)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $log->execute([
            $user['email'], $input['uname'], $listing['pid'], $listing['ptype'], $listing['pname'],
            $type, $qty, $listing['price'],
        ]);

        $pdo->commit();
    } catch (PDOException $ex) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log("Trade: failed to record $type: " . $ex->getMessage());
        flash('error', 'Your request could not be saved. Please try again.');
        $_SESSION['old_input'] = $input;
        redirect($back);
    }

    flash('success', $type === 'import'
        ? 'Import request placed. A mediator will pick up your item within 3 days.'
        : 'Export request placed. A mediator will pick up your item within 3 days.');
    redirect('16_invoice.php');
}
