
<?php
require_once dirname(__FILE__) . '/../views/header.php';
require_once dirname(__FILE__) . '/../config/db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AFT Judgements</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .d-flex button {
            width: 150px;
        }
        .truncate {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .truncate:hover {
            text-overflow: clip;
            white-space: normal;
            word-wrap: break-word;
        }
        /* Loader styles */
        .loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1050;
            display: none; /* Hidden initially */
        }
    </style>
</head>
<body>

<h1 class="text-center mb-4" id="tableTitle">AFT Judgements</h1>

<!-- Loader Overlay -->
<div class="loader-overlay" id="loader">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<!-- Bench Buttons -->
<div class="d-flex flex-wrap justify-content-center gap-3 my-4">
    <button type="button" class="btn btn-primary bench-btn" data-bench="Chennai">Chennai</button>
    <button type="button" class="btn btn-success bench-btn" data-bench="Chandigarh">Chandigarh</button>
    <button type="button" class="btn btn-info bench-btn" data-bench="Kochi">Kochi</button>
    <button type="button" class="btn btn-warning text-dark bench-btn" data-bench="Mumbai">Mumbai</button>
    <button type="button" class="btn btn-danger bench-btn" data-bench="Srinagar">Srinagar</button>
    <button type="button" class="btn btn-secondary bench-btn" data-bench="Jabalpur">Jabalpur</button>
</div>

<!-- Table to Display Judgements -->
<div class="table-responsive">
    <table id="dataTable" class="table table-bordered table-hover display nowrap">
        <thead>
            <tr>
                <th>#</th>
                <th>Year</th>
                <th>Month</th>
                <th>Judge 1</th>
                <th>Judge 2</th>
                <th>Case No</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <!-- Rows will be inserted dynamically -->
        </tbody>
    </table>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<!-- JSZip for Excel export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<!-- PDFMake for PDF export -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
   $(document).ready(function () {
    // Function to get URL parameter
    function getURLParameter(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    const dataTable = $('#dataTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        lengthMenu: [ [5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"] ],
        pageLength: 10,
        dom: 'lBfrtip',
        buttons: [
            { extend: 'copy', title: 'AFT Judgements' },
            { extend: 'excel', title: 'AFT Judgements' },
            { extend: 'pdf', title: 'AFT Judgements' },
            { extend: 'print', title: 'AFT Judgements' }
        ]
    });

    // Load data if 'bench' parameter is present in the URL
    const initialBench = getURLParameter('bench');
    if (initialBench) {
        loadBenchData(initialBench);
        $('#tableTitle').text(`AFT Judgements - ${initialBench}`);
    }

    // Event listener for bench buttons
    $('.bench-btn').on('click', function () {
        $('.bench-btn').removeClass('active');
        $(this).addClass('active');
        const selectedBench = $(this).data('bench');

        // Update the URL with the selected bench as a parameter
        const newUrl = `${window.location.pathname}?bench=${encodeURIComponent(selectedBench)}`;
        window.history.pushState({ path: newUrl }, '', newUrl);

        // Update the header title with the selected bench
        $('#tableTitle').text(`AFT Judgements - ${selectedBench}`);
        loadBenchData(selectedBench);
    });

    // Function to load data for the selected bench
    function loadBenchData(bench) {
        $('#loader').fadeIn();
        $.ajax({
            url: `fetch_judgements.php?bench=${encodeURIComponent(bench)}`,
            type: 'GET',
            success: function (data) {
                let judgements = JSON.parse(data);
                let rows = '';

                judgements.forEach((row, index) => {
                    const link = `https://aftdelhi.nic.in/${row.path}`;
                    rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${row.year}</td>
                            <td>${row.mon}</td>
                            <td class="truncate" data-bs-toggle="tooltip" title="${row.judge1}">
                                ${row.judge1.substring(0, 30)}
                            </td>
                            <td class="truncate" data-bs-toggle="tooltip" title="${row.judge2}">
                                ${row.judge2.substring(0, 30)}
                            </td>
                            <td class="dynamic-case-no" data-bs-toggle="tooltip" title="${row.case_no}">
                                ${row.case_no.length > 20 ? row.case_no.substring(0, 20) + '...' : row.case_no}
                            </td>
                            <td>
                                <a href="${link}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="bi bi-file-earmark-pdf-fill"></i> View PDF
                                </a>
                            </td>
                        </tr>`;
                });

                $('#dataTable').DataTable().clear().destroy();
                $('#tableBody').html(rows);
                $('#dataTable').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    lengthMenu: [ [5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"] ],
                    pageLength: 10,
                    dom: 'lBfrtip',
                    buttons: [
                        { extend: 'copy', title: `AFT Judgements - ${bench}` },
                        { extend: 'excel', title: `AFT Judgements - ${bench}` },
                        { extend: 'pdf', title: `AFT Judgements - ${bench}` },
                        { extend: 'print', title: `AFT Judgements - ${bench}` }
                    ]
                });
            },
            error: function () {
                alert('An error occurred while fetching data. Please try again.');
            },
            complete: function () {
                $('#loader').fadeOut();
            }
        });
    }
});


</script>

</body>
</html>

