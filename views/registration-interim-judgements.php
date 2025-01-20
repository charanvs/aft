<?php 
include_once dirname(__FILE__).'/header.php';
include_once dirname(__FILE__).'/../models/DailyOrdersModel.php';

$model = new DailyOrdersModel();

// Initialize variables with default values
$courtNo = filter_input(INPUT_GET, 'court_no', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
$registrationNo = filter_input(INPUT_GET, 'registration_no', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
$fromDateField = filter_input(INPUT_GET, 'from_date', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
$fromDate = '';
if (!empty($fromDateField)) {
    $parsedDate = strtotime($fromDateField);
    $fromDate = $parsedDate !== false ? date('d-m-Y', $parsedDate) : '';
}

$applicant = filter_input(INPUT_GET, 'applicant', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
$respondent = filter_input(INPUT_GET, 'respondent', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';
$advocate = filter_input(INPUT_GET, 'advocate', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '';

$recordPerPage = filter_input(INPUT_GET, 'record_per_page', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '10';
// Validate and sanitize recordPerPage
if (!in_array($recordPerPage, ['10', '25', '50', '100', '250', '500', 'All'])) {
    $recordPerPage = '10';
}

$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?? 1;
if ($page < 1) {
    $page = 1;
}

$filterData = [
    'registration_no' => $registrationNo,
    'courtno' => $courtNo,
    'aft_interim_judgements.dol' => $fromDate,
    'applicant' => $applicant,
    'respondent' => $respondent,
    'advocate' => $advocate
];

$startPage = $recordPerPage === 'All' ? 0 : ($page - 1) * $recordPerPage;

// Fetch results based on $recordPerPage
$orderClause = " ORDER BY id DESC";
if ($recordPerPage === 'All') {
    $results = $model->getOrderFilter2($filterData, $orderClause);
} else {
    $results = $model->getOrderFilter2($filterData, "$orderClause LIMIT $startPage, $recordPerPage");
}

// Get the total number of records
$totalRecords = $results ? ($model->getOrderFilter2($filterData, '', 'total')[0]['total'] ?? 0) : 0;
$totalPages = $recordPerPage === 'All' ? 1 : ceil($totalRecords / $recordPerPage);

function formatApplicantName($name) {
    return preg_replace_callback('/\d+/', function ($matches) {
        $digits = $matches[0];
        return str_repeat('x', max(strlen($digits) - 3, 0)) . substr($digits, -3);
    }, $name);
    return $name;
}
?>
<style>
    .applicant-column {
    width: 150px; /* Adjust the width as needed */
    max-width: 150px;
    white-space: nowrap; /* Prevent wrapping */
    overflow: hidden;
    text-overflow: ellipsis; /* Show ellipsis for overflowing text */
}

</style>
<section class="container mt-3">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5>Daily Order</h5>
                </div>
                <div class="col-12 col-md-6 text-md-right mt-2 mt-md-0">
                    <label for="record_per_page" class="mr-2">Items per page</label>
                    <select id="record_per_page" class="form-control-sm" onchange="filter()">
                        <?php foreach (['10', '25', '50', '100', '250', '500', 'All'] as $value): ?>
                            <option value="<?= $value ?>" <?= $recordPerPage == $value ? 'selected' : '' ?>><?= $value ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="filterForm">
                <div class="form-row">
                    <div class="form-group col-12 col-sm-6 col-md-2">
                        <input type="date" id="from_date" name="from_date" class="form-control-sm w-100" value="<?= htmlspecialchars($fromDateField) ?>">
                    </div>
                    <div class="form-group col-12 col-sm-6 col-md-2">
                        <select name="court_no" id="court_no" class="form-control-sm w-100">
                            <option value="">All Courts</option>
                            <?php foreach (range(1, 4) as $court): ?>
                                <option value="<?= $court ?>" <?= $courtNo == $court ? 'selected' : '' ?>><?= $court ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-12 col-sm-6 col-md-2">
                    <input name="registration_no" type="text" id="registration_no" placeholder="Registration No." 
       class="form-control-sm w-100" 
       value="<?= htmlspecialchars($registrationNo) ?>" 
       oninput="formatRegistrationNo(this)">
                    </div>
                    <div class="form-group col-12 col-sm-6 col-md-2">
                        <input name="applicant" type="text" id="applicant" placeholder="Applicant's Name" class="form-control-sm w-100" value="<?= htmlspecialchars($applicant) ?>">
                    </div>
                    <div class="form-group col-12 col-sm-6 col-md-2">
                        <input name="respondent" type="text" id="respondent" placeholder="Respondent's Name" class="form-control-sm w-100" value="<?= htmlspecialchars($respondent) ?>">
                    </div>
                    <div class="form-group col-12 col-sm-6 col-md-2">
                        <input name="advocate" type="text" id="advocate" placeholder="Advocate Name" class="form-control-sm w-100" value="<?= htmlspecialchars($advocate) ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-12 col-sm-6 col-md-2">
                        <button type="button" onclick="filter()" class="btn btn-sm btn-primary btn-block"><i class="fa fa-search mr-1"></i>Search</button>
                    </div>
                    <div class="form-group col-12 col-sm-6 col-md-2">
                        <button type="button" onclick="resetFilters()" class="btn btn-sm btn-secondary btn-block"><i class="fa fa-undo mr-1"></i>Reset</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Reg No.</th>
                            <th>Next Date</th>
                            <th>Order</th>
                            <th>Court</th>
                            <th>Date Listing</th>
                            <th class="applicant-column">Applicant</th>
                            <th>Respondent</th>
                            <th>PAdvocate</th>
                            <th>RAdvocate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($results)) { 
                            $sno = ($page - 1) * $recordPerPage;
                            foreach ($results as $key) {  
                                $sno++; ?>
                                <tr>
                                    <td><?= $sno ?></td>
                                    <td><?= htmlspecialchars($key['registration_no'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($key['dol'] ?? '') ?></td>
                                    <td>
                                        <a href="https://aftdelhi.nic.in/assets/pending_cases/<?= $key['year'] ?>/<?= $key['case_type_name'] ?>/<?= $key['pdfname'] ?>" target="_blank">
                                            <i class="fa fa-eye mr-1"></i>View
                                        </a>
                                    </td>
                                    <td><?= htmlspecialchars($key['courtno'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($key['interim_dol'] ?? '') ?></td>
                                    <td class="applicant-column" title="<?= htmlspecialchars(preg_replace_callback('/\d+/', function ($matches) {
    $digits = $matches[0];
    $masked = str_repeat('x', max(strlen($digits) - 3, 0)) . substr($digits, -3);
    return $masked;
}, $key['applicant'] ?? '')) ?>">
    <?= htmlspecialchars(preg_replace_callback('/\d+/', function ($matches) {
        $digits = $matches[0];
        $masked = str_repeat('x', max(strlen($digits) - 3, 0)) . substr($digits, -3);
        return $masked;
    }, $key['applicant'] ?? '')) ?>
</td>


                                    <td class="applicant-column" title="<?= htmlspecialchars($key['respondent'] ?? '') ?>">
                                        <?= mb_strimwidth(htmlspecialchars($key['respondent'] ?? ''), 0, 20, '...') ?>
                                    </td>
                                    <td class="applicant-column" title="<?= htmlspecialchars($key['padvocate'] ?? '') ?>">
                                        <?= mb_strimwidth(htmlspecialchars($key['padvocate'] ?? ''), 0, 20, '...') ?>
                                    </td>
                                    <td class="applicant-column" title="<?= htmlspecialchars($key['radvocate'] ?? '') ?>">
                                        <?= mb_strimwidth(htmlspecialchars($key['radvocate'] ?? ''), 0, 20, '...') ?>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="10" class="text-center">No records found.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php if ($recordPerPage !== 'All') {
                echo '<nav><ul class="pagination justify-content-center">';

                $maxPagesToShow = 10;
                $startPage = max(1, $page - floor($maxPagesToShow / 2));
                $endPage = min($totalPages, $startPage + $maxPagesToShow - 1);
                $startPage = max(1, $endPage - $maxPagesToShow + 1);

                if ($page > 1) {
                    echo "<li class='page-item'><a class='page-link' href='?" . http_build_query(array_merge($_GET, ['page' => $page - 1])) . "'>&laquo; Prev</a></li>";
                }

                for ($i = $startPage; $i <= $endPage; $i++) {
                    $active = $i == $page ? 'active' : '';
                    echo "<li class='page-item $active'><a class='page-link' href='?" . http_build_query(array_merge($_GET, ['page' => $i])) . "'>$i</a></li>";
                }

                if ($page < $totalPages) {
                    echo "<li class='page-item'><a class='page-link' href='?" . http_build_query(array_merge($_GET, ['page' => $page + 1])) . "'>Next &raquo;</a></li>";
                }

                echo '</ul></nav>';
            } ?>
        </div>
    </div>
</section>

<script>
    function formatRegistrationNo(input) {
        // Add a space after any alphabetic characters followed by digits
        input.value = input.value.replace(/([a-zA-Z]+)(\d+)/, '$1 $2');
    }
    function filter() {
        const params = new URLSearchParams(new FormData(document.getElementById('filterForm')));
        const recordPerPage = document.getElementById('record_per_page').value;
        params.set('record_per_page', recordPerPage);
        params.set('page', 1); // Reset to the first page on filter change
        window.location.href = "<?= url.'views/registration-interim-judgements.php' ?>?" + params.toString();
    }

    function resetFilters() {
        window.location.href = "<?= url.'views/registration-interim-judgements.php' ?>";
    }
</script>

<?php include_once dirname(__FILE__).'/footer.php'; ?>
