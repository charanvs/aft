<?php
require_once dirname(__FILE__) . '/../views/header.php';
require_once dirname(__FILE__) . '/../config/db_connection.php';

// Get the selected date from the URL parameter
$date = $_GET['date'] ?? null;

if ($date) {
    // Query to fetch records with associated values from aft_associatedwith
    $query = "SELECT ar.*, ad.courtno, mc.matter AS matter_name, 
                 IFNULL((SELECT GROUP_CONCAT(aw.associatedwith SEPARATOR ', ') 
                         FROM aft_associatedwith aw 
                         WHERE aw.regid = ar.id), 'NA') AS associated_with
          FROM aft_registration ar
          JOIN aft_dol_dependency ad ON ar.id = ad.regid AND ar.dol COLLATE latin1_general_ci = ad.dol COLLATE latin1_general_ci
          JOIN aft_matter_court mc ON ad.matter = mc.id
          WHERE ar.dol = ?
          ORDER BY ad.courtno, mc.matter, ar.registration_no";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentative List for <?php echo htmlspecialchars($date); ?></title>

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
            border-collapse: collapse;
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
        tr.group-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        tr.sub-header {
            background-color: #e0e7ff;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Tentative List for <?php echo htmlspecialchars($date); ?></h1>

<!-- Court No Filter Dropdown -->
<label for="courtFilter">Filter by Court No:</label>
<select id="courtFilter" class="form-select" style="width:200px; display:inline-block; margin-bottom: 10px;">
    <option value="">Show All</option>
    <?php 
    // Get unique court numbers
    $courtNos = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (!in_array($row['courtno'], $courtNos)) {
                $courtNos[] = $row['courtno'];
                echo "<option value='" . htmlspecialchars($row['courtno']) . "'>" . htmlspecialchars($row['courtno']) . "</option>";
            }
        }
    }
    // Reset result pointer for table display
    $result->data_seek(0);
    ?>
</select>

<table id="dataTable" class="display nowrap" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Registration No</th>
            <th class="ellipsis">Applicant</th>
            <th class="ellipsis">Respondent</th>
            <th class="ellipsis">P. Advocate</th>
            <th class="ellipsis">R. Advocate</th>
            <th style="display:none;">Court No</th> <!-- Hidden column for courtno -->
        </tr>
    </thead>
    <tbody>
        <?php 
        $sr_no = 1;
        while ($row = $result->fetch_assoc()): 
            $displayRegNo = htmlspecialchars($row['registration_no']);
            $associatedWith = $row['associated_with'] !== 'NA' ? " {$displayRegNo} with {$row['associated_with']}" : $displayRegNo;
        ?>
        <tr data-courtno="<?php echo htmlspecialchars($row['courtno']); ?>" data-matter="<?php echo htmlspecialchars($row['matter_name']); ?>">
            <td><?php echo $sr_no++; ?></td>
            <td><?php echo $associatedWith; ?></td>
            <td class="ellipsis" title="<?php echo htmlspecialchars($row['applicant']); ?>">
                <?php echo htmlspecialchars($row['applicant']); ?>
            </td>
            <td class="ellipsis" title="<?php echo htmlspecialchars($row['respondent']); ?>">
                <?php echo htmlspecialchars($row['respondent']); ?>
            </td>
            <td class="ellipsis" title="<?php echo htmlspecialchars($row['padvocate']); ?>">
                <?php echo htmlspecialchars($row['padvocate']); ?>
            </td>
            <td class="ellipsis" title="<?php echo htmlspecialchars($row['radvocate']); ?>">
                <?php echo htmlspecialchars($row['radvocate']); ?>
            </td>
            <td style="display:none;"><?php echo htmlspecialchars($row['courtno']); ?></td> <!-- Hidden Court No data -->
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php $conn->close(); ?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<!-- DataTables Buttons for exporting data -->
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
    var table = $('#dataTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "order": [[0, 'asc']],
        "dom": 'lBfrtip',
        "lengthMenu": [5, 10, 25, 50, 100],
        "pageLength": 10,
        "buttons": [
            { extend: 'copy', title: "Tentative List for <?php echo htmlspecialchars($date); ?>" },
            { extend: 'excel', title: "Tentative List for <?php echo htmlspecialchars($date); ?>" },
            { 
                extend: 'pdf', 
                title: "Tentative List for <?php echo htmlspecialchars($date); ?>",
                orientation: 'landscape',
                pageSize: 'A4'
            },
            { extend: 'print', title: "Tentative List for <?php echo htmlspecialchars($date); ?>" }
        ],
        "columnDefs": [
            { "targets": [6], "visible": false }  // Hide the Court No column from display
        ],
        "drawCallback": function (settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var lastCourtNo = null;
            var lastMatter = null;

            $(rows).find('.group-header, .sub-header').remove();  // Clear previous headers

            api.rows({ page: 'current' }).every(function (i) {
                var courtno = $(this.node()).data('courtno');
                var matter = $(this.node()).data('matter');

                // Insert Court No header
                if (lastCourtNo !== courtno) {
                    $(rows).eq(i).before(
                        '<tr class="group-header"><td colspan="6">Court No: ' + courtno + '</td></tr>'
                    );
                    lastCourtNo = courtno;
                    lastMatter = null;
                }

                // Insert Matter subheader
                if (lastMatter !== matter) {
                    $(rows).eq(i).before(
                        '<tr class="sub-header"><td colspan="6">Matter: ' + matter + '</td></tr>'
                    );
                    lastMatter = matter;
                }
            });
        }
    });

    // Filter by court number
    $('#courtFilter').on('change', function () {
        var courtNo = $(this).val();
        table.column(6).search(courtNo ? '^' + courtNo + '$' : '', true, false).draw();
    });
  });
</script>

</body>
</html>


