<?php
require_once dirname(__FILE__) . '/../views/header.php';
require_once dirname(__FILE__) . '/../config/db_connection.php';

// Fetch records from rb_cause_lists
$query = "SELECT id, DATE_FORMAT(date_cause_list, '%d-%m-%Y') as formatted_date, bench_name, file_name, type_document FROM rb_cause_lists";
$result = $conn->query($query);

if (!$result) {
    die("Query Error: " . $conn->error);
}

// Store data in an array
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regional Bench Cause Lists</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .page-title {
            margin-top: 20px;
            text-align: center;
            color: #343a40;
        }
        .table-container {
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .modal-lg {
            max-width: 80%;
        }
        .filter-buttons {
            text-align: center;
            margin-bottom: 20px;
        }
        .filter-buttons .btn {
            margin: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="page-title">Cause Lists</h1>

    <!-- Filter Buttons -->
    <div class="filter-buttons">
        <button class="btn btn-outline-primary" onclick="filterTable('Chennai')">Chennai</button>
        <button class="btn btn-outline-success" onclick="filterTable('Kochi')">Kochi</button>
        <button class="btn btn-outline-danger" onclick="filterTable('Jabalpur')">Jabalpur</button>
        <button class="btn btn-outline-warning" onclick="filterTable('Mumbai')">Mumbai</button>
        <button class="btn btn-outline-secondary" onclick="filterTable('')">Show All</button>
    </div>

    <div class="table-container">
        <table class="table table-hover table-bordered" id="causeListTable">
            <thead class="table-primary">
                <tr>
                    <th scope="col">S. No.</th>
                    <th scope="col">Date Cause List</th>
                    <th scope="col">Type</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data)): ?>
                    <?php foreach ($data as $index => $row): ?>
                        <tr data-bench-name="<?php echo htmlspecialchars($row['bench_name']); ?>">
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($row['formatted_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['type_document']); ?></td>
                            <td>
                                <?php if (!empty($row['file_name'])): ?>
                                    <button class="btn btn-primary btn-sm" 
                                            onclick="showPDFModal('http://aftpb.org/aft/public/<?php echo htmlspecialchars($row['file_name']); ?>')">
                                        View
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted">No File</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">PDF Viewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdfFrame" src="" width="100%" height="500px" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize DataTables
        const table = $('#causeListTable').DataTable({
            "order": [[1, "asc"]],
            "paging": true,
            "searching": true,
            "lengthChange": true
        });

        // Filter Table Rows
        window.filterTable = function (benchName) {
            const rows = document.querySelectorAll('#causeListTable tbody tr');
            rows.forEach(row => {
                if (benchName === '' || row.getAttribute('data-bench-name') === benchName) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            reinitializeSerialNumbers();
        };

        // Reinitialize Serial Numbers
        function reinitializeSerialNumbers() {
            let visibleRows = Array.from(document.querySelectorAll('#causeListTable tbody tr:not([style*="display: none"])'));
            visibleRows.sort((a, b) => {
                let dateA = new Date(a.children[1].textContent.trim());
                let dateB = new Date(b.children[1].textContent.trim());
                return dateA - dateB;
            }).forEach((row, index) => {
                row.children[0].textContent = index + 1;
                document.querySelector('#causeListTable tbody').appendChild(row);
            });
        }
    });

    // Show PDF Modal
    function showPDFModal(fileURL) {
        document.getElementById('pdfFrame').src = fileURL;
        const pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
        pdfModal.show();
    }
</script>
</body>
</html>
