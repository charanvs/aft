<?php require_once dirname(__FILE__).'/../views/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diary Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS for Table Header Word Wrapping -->
<style>
    /* Ensure table headers wrap long words or phrases */
    .table th {
        white-space: normal !important; /* Allow words to wrap in th */
        word-wrap: break-word;
    }

    /* Existing Custom styles for modal */
    .modal-dialog { 
        max-width: 600px; 
        width: 100%; 
    }
    .modal-content { 
        padding: 20px; 
    }
    .modal-header { 
        background-color: #007bff; 
        color: white; 
    }
    .modal-title { 
        font-size: 1.3em; 
        font-weight: bold; 
    }
    .info-section {
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 15px;
    }
    .essential-info { 
        background-color: #f9f9f9; 
        font-weight: bold; 
    }
    .non-essential-info, .defects-section { 
        background-color: #f1f1f1; 
        font-size: 0.95em; 
    }
    .table th, .table td { 
        vertical-align: middle; 
    }
    .status-button { 
        width: 100%; 
        margin-top: 5px; 
    }

    /* Full-Screen Modal Styles */
    .modal-fullscreen {
        width: 100%;
        max-width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }
    .modal-content {
        height: 100%;
        overflow-y: auto;
    }
</style>
    <script>
        function resetForm() {
            document.getElementById("searchForm").reset();
            const fieldsToReset = ['diary_no', 'date_of_presentation', 'presented_by'];
            fieldsToReset.forEach(id => document.getElementById(id).value = "");
            document.getElementById("results_per_page").selectedIndex = 1;
            const url = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.pushState({ path: url }, '', url);
        }

        function setModalContent(modalData) {
    const fieldMapping = {
        DiaryNo: 'diary_no',
        DateOfPresentation: 'date_of_presentation',
        NatureOfDoc: 'nature_of_doc',
        AssociatedWith: 'associated_with',
        PresentedBy: 'presented_by',
        ReviewedBy: 'reviewed_by',
        SectionOfficerRemark: 'section_officer_remark',
        DeputyRegistrarRemark: 'deputy_registrar_remark',
        RegistrarRemark: 'registrar_remark',
        NotCompletedObservations: 'not_completed_observations',
        CaseType: 'casetype',
        NoOfApplicants: 'no_of_applicants',
        NoOfRespondents: 'no_of_respondents',
        Initial: 'initial',
        Remark: 'remark',
        CaRemark: 'ca_remark',
        NotificationRemark: 'notification_remark',
        NotificationDate: 'notification_date',
        NatureOfGrievanceOther: 'nature_of_grievance_other'
    };

    Object.keys(fieldMapping).forEach(field => {
        const modalField = fieldMapping[field];  // Get the snake_case field from the mapping
        const value = modalData[modalField] || 'Not Available';  // Fetch the value or display 'Not Available'
        
        document.getElementById(`modal${field}`).innerText = value;
    });
}



        function viewDetails(...details) {
            const modalData = {
                id: details[0], diary_no: details[1], date_of_presentation: details[2], nature_of_doc: details[3],
                associated_with: details[4], presented_by: details[5], reviewed_by: details[6], 
                section_officer_remark: details[7], deputy_registrar_remark: details[8], registrar_remark: details[9], 
                not_completed_observations: details[10], casetype: details[11], no_of_applicants: details[12], 
                no_of_respondents: details[13], initial: details[14], remark: details[15], ca_remark: details[16],
                notification_remark: details[17], notification_date: details[18], nature_of_grievance_other: details[19]
            };
            setModalContent(modalData);
            $('#detailsModal').modal('show');
        }

        function viewStatus(id, diaryNo, type) {
    fetch(`get_defects.php?sid=${id}&type=${type}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Fetched data:', data);  // Log the fetched data for debugging
            
            const tableBody = document.getElementById('modalStatusContent');
            const modalLabel = document.getElementById("statusModalLabel");

            // Clear any previous content in the modal
            tableBody.innerHTML = '';

            // Display the diary number in the modal title
            modalLabel.innerText = `Status for Diary No: ${data.diary_no || diaryNo || "Not Available"} (${type || "Unknown"})`;

            // Check if we have a message to display
            if (data.message) {
                // Create a table row for the message
                const messageRow = `
                    <tr>
                        <td colspan="6" style="padding: 15px; text-align: center; font-size: 16px; font-weight: bold; color: green;">
                            ${data.message}
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += messageRow;
            }

            // Check if defects data exists
            if (data.defects && data.defects.length > 0) {
                // Insert the new paragraph before the table rows
                const notificationParagraph = `
                    <tr>
                        <td colspan="6" style="padding: 15px; font-size: 14px; font-weight: bold; text-align: left; color: #007bff;">
                            The papers filed in the following cases have been found on scrutiny to be defective. </br>
                            Hence, it is hereby notified that the Applicant(s)/Respondent(s) or his/their Legal </br> 
                            Practitioner is/are required to rectify the defects in the registry itself, if they are </br>
                            formal in nature or take back the papers for rectification of the defects and </br>
                            representation if they are not formal in nature, within the time shown against </br>
                            each case. 
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += notificationParagraph;

                // Now add the table header for defects
                const headerRow = `
                    <tr class="thead-dark">
                        <th style="width: 5%; text-align: center;">S.No.</th>
                        <th style="width: 25%;">Papers in which defects are noticed</th>
                        <th style="width: 20%;">By whom defects are to be rectified</th>
                        <th style="width: 20%;">Nature of defects</th>
                        <th style="width: 15%; text-align: center;">Time granted for rectification</th>
                        <th style="width: 15%; text-align: center;">Rectified</th>
                    </tr>
                `;
                tableBody.innerHTML += headerRow;

                // Loop through defects and append them as table rows
                data.defects.forEach((defect, index) => {
                    const row = `
                        <tr style="font-family: 'Arial', sans-serif; font-size: 14px; color: #333;">
                            <td style="padding: 10px; font-weight: bold; color: #007bff; text-align: center;">${index + 1}</td>
                            <td style="padding: 10px; word-wrap: break-word; max-width: 200px; white-space: normal;">${defect.defect || 'N/A'}</td>
                            <td style="padding: 10px; word-wrap: break-word; max-width: 200px; white-space: normal;">${defect.rectified_by || 'N/A'}</td>
                            <td style="padding: 10px; word-wrap: break-word; max-width: 200px; white-space: normal;">${defect.nature || 'N/A'}</td>
                            <td style="padding: 10px; text-align: center;">${defect.time_granted || 'N/A'}</td>
                            <td style="padding: 10px; text-align: center;">${defect.rectified || 'N/A'}</td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            } else if (!data.message) {
                // If no defects or message, show a default message
                tableBody.innerHTML = `<tr><td colspan="6" style="padding: 15px; text-align: center; font-size: 16px; font-weight: bold; color: #ff0000;">No defects found.</td></tr>`;
            }

            // Show the modal after content is added
            $('#statusModal').modal({
                backdrop: 'static',
                keyboard: false
            }).modal('show');
        })
        .catch(error => {
            console.error('Error fetching data:', error);  // Log any errors
            const tableBody = document.getElementById('modalStatusContent');
            tableBody.innerHTML = '<tr><td colspan="6" style="padding: 15px; text-align: center; font-size: 16px; font-weight: bold; color: #ff0000;">Error fetching status.</td></tr>';
        });
}





    function printModalContent() {
            const modalContent = document.querySelector('#detailsModal .modal-body').innerHTML;
            const printWindow = window.open('', '', 'height=800,width=600');
            printWindow.document.write(`
                <html><head><title>Print Diary Details</title><style>
                    body { font-family: Arial, sans-serif; }
                    .info-section { padding: 10px; margin-bottom: 10px; background-color: #f9f9f9; }
                </style></head><body>
                <h3>Diary Details</h3>${modalContent}</body></html>
            `);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }

        function printStatusModalContent() {
    const modalContent = document.querySelector('#statusModal .modal-body').innerHTML; // Get modal content
    const printWindow = window.open('', '', 'height=800,width=900'); // Open a new window for printing

    // Write the modal content into the print window with some styles
    printWindow.document.write(`
        <html>
        <head>
            <title>Print Status</title>
            <style>
                body { font-family: Arial, sans-serif; }
                .table { width: 100%; border-collapse: collapse; }
                .table, .table th, .table td { border: 1px solid #333; }
                .table th, .table td { padding: 10px; text-align: left; }
                .table thead { background-color: #f1f1f1; font-weight: bold; }
                h5 { font-size: 1.3em; font-weight: bold; }
                .thead-dark th { background-color: #007bff; color: white; }
            </style>
        </head>
        <body>
            <h5>${document.getElementById('statusModalLabel').innerText}</h5> <!-- Display modal title -->
            ${modalContent}
        </body>
        </html>
    `);

    printWindow.document.close(); // Close the document for writing
    printWindow.focus(); // Focus the new window
    printWindow.print(); // Trigger the print dialog
    printWindow.close(); // Close the print window after printing
}

    </script>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Diary Details</h2>
    <form method="get" id="searchForm" class="mb-4">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="diary_no">Diary No</label>
                <input type="text" name="diary_no" id="diary_no" class="form-control" value="<?php echo isset($_GET['diary_no']) ? htmlspecialchars($_GET['diary_no']) : ''; ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label for="date_of_presentation">Date of Presentation</label>
                <input type="date" name="date_of_presentation" id="date_of_presentation" class="form-control" value="<?php echo isset($_GET['date_of_presentation']) ? htmlspecialchars($_GET['date_of_presentation']) : ''; ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label for="presented_by">Presented By</label>
                <input type="text" name="presented_by" id="presented_by" class="form-control" value="<?php echo isset($_GET['presented_by']) ? htmlspecialchars($_GET['presented_by']) : ''; ?>">
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="results_per_page">Items per page</label>
                <select name="results_per_page" id="results_per_page" class="form-control">
                    <option value="5" <?php echo (isset($_GET['results_per_page']) && $_GET['results_per_page'] == 5) ? 'selected' : ''; ?>>5</option>
                    <option value="10" <?php echo (isset($_GET['results_per_page']) && $_GET['results_per_page'] == 10) ? 'selected' : ''; ?>>10</option>
                    <option value="25" <?php echo (isset($_GET['results_per_page']) && $_GET['results_per_page'] == 25) ? 'selected' : ''; ?>>25</option>
                    <option value="50" <?php echo (isset($_GET['results_per_page']) && $_GET['results_per_page'] == 50) ? 'selected' : ''; ?>>50</option>
                </select>
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">Search</button>
                <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
            </div>
        </div>
    </form>

    <!-- PHP for fetching and displaying data -->
    <?php
    // Include the database connection
    require_once dirname(__FILE__).'/../config/db_connection.php';

    // Refactored logic for data retrieval
    $results_per_page = isset($_GET['results_per_page']) ? (int)$_GET['results_per_page'] : 10;
    $results_per_page = max(1, $results_per_page);
    
    $conditions = "id > 60000";
    $params = [];
    $types = '';

    if (!empty($_GET['diary_no'])) {
        $conditions .= " AND diary_no LIKE ?";
        $params[] = "%" . $_GET['diary_no'] . "%";
        $types .= 's';
    }
    if (!empty($_GET['date_of_presentation'])) {
        $date = DateTime::createFromFormat('Y-m-d', $_GET['date_of_presentation']);
        if ($date) {
            $formattedDate = $date->format('d-m-Y');
            $conditions .= " AND date_of_presentation = ?";
            $params[] = $formattedDate;
            $types .= 's';
        }
    }
    if (!empty($_GET['presented_by'])) {
        $conditions .= " AND presented_by LIKE ?";
        $params[] = "%" . $_GET['presented_by'] . "%";
        $types .= 's';
    }

    $sql = "SELECT COUNT(id) AS total FROM aft_scrutiny WHERE $conditions";
    $stmt = $conn->prepare($sql);

    if (count($params) > 0) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_pages = ceil($row["total"] / $results_per_page);

    $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $current_page = max(1, min($current_page, $total_pages));

    $starting_limit = ($current_page - 1) * $results_per_page;
    $starting_limit = max(0, $starting_limit);

    $sql = "SELECT * FROM aft_scrutiny WHERE $conditions LIMIT ?, ?";
    $stmt = $conn->prepare($sql);

    $params[] = $starting_limit;
    $params[] = $results_per_page;
    $types .= 'ii';

    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="table-responsive">';
        echo '<table class="table table-bordered table-striped">';
        echo '<thead class="thead-dark">';
        echo '<tr><th>Diary No</th><th>Date of Presentation</th><th>Nature of Document</th><th>Associated With</th><th>Presented By</th><th>Actions</th><th>Status</th></tr>';
        echo '</thead><tbody>';
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["diary_no"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["date_of_presentation"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["nature_of_doc"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["associated_with"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["presented_by"]) . "</td>";
            echo '<td><button class="btn btn-info btn-sm" onclick="viewDetails(
                ' . $row["id"] . ', 
                \'' . htmlspecialchars($row["diary_no"]) . '\', 
                \'' . htmlspecialchars($row["date_of_presentation"]) . '\', 
                \'' . htmlspecialchars($row["nature_of_doc"]) . '\', 
                \'' . htmlspecialchars($row["associated_with"]) . '\', 
                \'' . htmlspecialchars($row["presented_by"]) . '\', 
                \'' . htmlspecialchars($row["reviewed_by"]) . '\', 
                \'' . htmlspecialchars($row["section_officer_remark"]) . '\', 
                \'' . htmlspecialchars($row["deputy_registrar_remark"]) . '\', 
                \'' . htmlspecialchars($row["registrar_remark"]) . '\', 
                \'' . htmlspecialchars($row["not_completed_observations"]) . '\', 
                \'' . htmlspecialchars($row["casetype"]) . '\', 
                \'' . htmlspecialchars($row["no_of_applicants"]) . '\', 
                \'' . htmlspecialchars($row["no_of_respondents"]) . '\', 
                \'' . htmlspecialchars($row["initial"]) . '\', 
                \'' . htmlspecialchars($row["remark"]) . '\', 
                \'' . htmlspecialchars($row["ca_remark"]) . '\', 
                \'' . htmlspecialchars($row["notification_remark"]) . '\', 
                \'' . htmlspecialchars($row["notification_date"]) . '\', 
                \'' . htmlspecialchars($row["nature_of_grievance_other"]) . '\'
                )">View</button></td>';

            echo '<td><button class="btn btn-warning btn-sm status-button" onclick="viewStatus(' . $row["id"] . ', \'' . htmlspecialchars($row["diary_no"]) . '\', \'registration\')">Status</button></td>';
            echo "</tr>";
        }
        
        echo '</tbody></table>';
        echo '</div>';

        echo '<nav aria-label="Page navigation">';
        echo '<ul class="pagination justify-content-center">';

        if ($current_page > 1) {
            echo '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . ($current_page - 1) . '&' . http_build_query($_GET) . '">Previous</a></li>';
        } else {
            echo '<li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>';
        }

        $range = 2;
        $start = max(1, $current_page - $range);
        $end = min($total_pages, $current_page + $range);

        if ($start > 1) {
            echo '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=1&' . http_build_query($_GET) . '">1</a></li>';
            if ($start > 2) {
                echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
            }
        }

        for ($page = $start; $page <= $end; $page++) {
            $get_params = $_GET;
            $get_params['page'] = $page;
            if ($page == $current_page) {
                echo '<li class="page-item active"><a class="page-link" href="#">' . $page . '</a></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?' . http_build_query($get_params) . '">' . $page . '</a></li>';
            }
        }

        if ($end < $total_pages) {
            if ($end < $total_pages - 1) {
                echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
            }
            echo '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . $total_pages . '&' . http_build_query($_GET) . '">' . $total_pages . '</a></li>';
        }

        if ($current_page < $total_pages) {
            echo '<li class="page-item"><a class="page-link" href="' . $_SERVER['PHP_SELF'] . '?page=' . ($current_page + 1) . '&' . http_build_query($_GET) . '">Next</a></li>';
        } else {
            echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
        }

        echo '</ul>';
        echo '</nav>';
    } else {
        echo '<div class="alert alert-warning" role="alert">No results found.</div>';
    }

    $conn->close();
    ?>

    <!-- Modal for Viewing Details -->
    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Diary Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Essential Information Section -->
                    <div class="info-section essential-info">
                        <p><strong>Diary No:</strong> <span id="modalDiaryNo"></span></p>
                        <p><strong>Date of Presentation:</strong> <span id="modalDateOfPresentation"></span></p>
                        <p><strong>Nature of Document:</strong> <span id="modalNatureOfDoc"></span></p>
                        <p><strong>Associated With:</strong> <span id="modalAssociatedWith"></span></p>
                        <p><strong>Presented By:</strong> <span id="modalPresentedBy"></span></p>
                        <p><strong>Reviewed By:</strong> <span id="modalReviewedBy"></span></p>
                    </div>

                    <!-- Non-Essential Information Section -->
                    <div class="info-section non-essential-info">
                        <p><strong>Section Officer Remark:</strong> <span id="modalSectionOfficerRemark"></span></p>
                        <p><strong>Deputy Registrar Remark:</strong> <span id="modalDeputyRegistrarRemark"></span></p>
                        <p><strong>Registrar Remark:</strong> <span id="modalRegistrarRemark"></span></p>
                        <p><strong>Not Completed Observations:</strong> <span id="modalNotCompletedObservations"></span></p>
                        <p><strong>Case Type:</strong> <span id="modalCaseType"></span></p>
                        <p><strong>No of Applicants:</strong> <span id="modalNoOfApplicants"></span></p>
                        <p><strong>No of Respondents:</strong> <span id="modalNoOfRespondents"></span></p>
                        <p><strong>Initial:</strong> <span id="modalInitial"></span></p>
                        <p><strong>Remark:</strong> <span id="modalRemark"></span></p>
                        <p><strong>CA Remark:</strong> <span id="modalCaRemark"></span></p>
                        <p><strong>Notification Remark:</strong> <span id="modalNotificationRemark"></span></p>
                        <p><strong>Notification Date:</strong> <span id="modalNotificationDate"></span></p>
                        <p><strong>Nature of Grievance (Other):</strong> <span id="modalNatureOfGrievanceOther"></span></p>
                    </div>

                    <!-- Defects Section -->
                    <!-- <div class="info-section defects-section">
                        <p><strong>Current Staus:</strong> <span id="modalDefects"></span></p>
                        <button id="viewDefectsButton" class="btn btn-warning btn-sm mt-2" onclick="viewStatus()">View Status</button>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printModalContent()">Print</button>
                </div>
            </div>
        </div>
    </div>

<!-- Modal for Viewing Status (Medium-Sized Modal) -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #007bff; color: white;">
                <h5 class="modal-title" id="statusModalLabel" style="font-weight: bold;">Status for Diary No:</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                   
                    <tbody id="modalStatusContent">
                        <!-- Dynamic rows will be inserted here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- Print button -->
                <button type="button" class="btn btn-primary" onclick="printStatusModalContent()">Print</button>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
