<?php require_once dirname(__FILE__).'/../views/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diary Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function resetForm() {
            document.getElementById("searchForm").reset();
            document.getElementById("diary_no").value = "";
            document.getElementById("date_of_presentation").value = "";
            document.getElementById("presented_by").value = "";
            document.getElementById("results_per_page").selectedIndex = 1;

            const url = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.pushState({ path: url }, '', url);
        }

        function viewDetails(id, diary_no, date_of_presentation, nature_of_doc, associated_with, presented_by, reviewed_by, nature_of_grievance, nature_of_grievance_code, subject, subject_code, result, section_officer_remark, deputy_registrar_remark, registrar_remark, not_completed_observations, casetype, no_of_applicants, no_of_respondents, initial, remark, ca_remark, notification_remark, notification_date, nature_of_grievance_other) {
            document.getElementById("modalDiaryNo").innerText = diary_no || 'Not Available';
            document.getElementById("modalDateOfPresentation").innerText = date_of_presentation || 'Not Available';
            document.getElementById("modalNatureOfDoc").innerText = nature_of_doc || 'Not Available';
            document.getElementById("modalAssociatedWith").innerText = associated_with || 'Not Available';
            document.getElementById("modalPresentedBy").innerText = presented_by || 'Not Available';
            document.getElementById("modalReviewedBy").innerText = reviewed_by || 'Not Available';
            document.getElementById("modalNatureOfGrievance").innerText = nature_of_grievance || 'Not Available';
            document.getElementById("modalNatureOfGrievanceCode").innerText = nature_of_grievance_code || 'Not Available';
            document.getElementById("modalSubject").innerText = subject || 'Not Available';
            document.getElementById("modalSubjectCode").innerText = subject_code || 'Not Available';
            document.getElementById("modalResult").innerText = result || 'Not Available';
            document.getElementById("modalSectionOfficerRemark").innerText = section_officer_remark || 'Not Available';
            document.getElementById("modalDeputyRegistrarRemark").innerText = deputy_registrar_remark || 'Not Available';
            document.getElementById("modalRegistrarRemark").innerText = registrar_remark || 'Not Available';
            document.getElementById("modalNotCompletedObservations").innerText = not_completed_observations || 'Not Available';
            document.getElementById("modalCaseType").innerText = casetype || 'Not Available';
            document.getElementById("modalNoOfApplicants").innerText = no_of_applicants || 'Not Available';
            document.getElementById("modalNoOfRespondents").innerText = no_of_respondents || 'Not Available';
            document.getElementById("modalInitial").innerText = initial || 'Not Available';
            document.getElementById("modalRemark").innerText = remark || 'Not Available';
            document.getElementById("modalCaRemark").innerText = ca_remark || 'Not Available';
            document.getElementById("modalNotificationRemark").innerText = notification_remark || 'Not Available';
            document.getElementById("modalNotificationDate").innerText = notification_date || 'Not Available';
            document.getElementById("modalNatureOfGrievanceOther").innerText = nature_of_grievance_other || 'Not Available';
            document.getElementById("modalDefects").innerText = ""; // Defects will be fetched separately
            document.getElementById("viewDefectsButton").setAttribute("data-id", id);
            $('#detailsModal').modal('show');
    }


        function viewDefects() {
            const id = document.getElementById("viewDefectsButton").getAttribute("data-id");

            fetch(`get_defects.php?sid=${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(data => {
                    try {
                        const parsedData = JSON.parse(data);

                        if (parsedData.message) {
                            document.getElementById("modalDefects").innerText = parsedData.message;
                        } else if (Array.isArray(parsedData) && parsedData.length > 0) {
                            let defectsList = '<ul>';
                            parsedData.forEach(defect => {
                                defectsList += `<li>${defect}</li>`;
                            });
                            defectsList += '</ul>';
                            document.getElementById("modalDefects").innerHTML = defectsList;
                        } else {
                            document.getElementById("modalDefects").innerText = "No defects found.";
                        }
                    } catch (error) {
                        document.getElementById("modalDefects").innerText = "Error fetching defects.";
                    }
                })
                .catch(error => {
                    document.getElementById("modalDefects").innerText = "Error fetching defects.";
                });
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

    <?php
    // Include the database connection
require_once dirname(__FILE__).'/../config/db_connection.php';


    // Define how many results you want per page
    $results_per_page = isset($_GET['results_per_page']) ? (int)$_GET['results_per_page'] : 10;
    $results_per_page = max(1, $results_per_page); // Ensure it's at least 1

    // Initialize the search query conditions
    $conditions = "id > 50000";
    $params = [];
    $types = ''; // To store parameter types for bind_param

    if (!empty($_GET['diary_no'])) {
        $conditions .= " AND diary_no LIKE ?";
        $params[] = "%" . $_GET['diary_no'] . "%";
        $types .= 's';
    }
    if (!empty($_GET['date_of_presentation'])) {
        // Convert the input date from yyyy-mm-dd to dd-mm-yyyy
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

    // Prepare the total count query with search conditions
    $sql = "SELECT COUNT(id) AS total FROM aft_scrutiny WHERE $conditions";
    $stmt = $conn->prepare($sql);

    if (count($params) > 0) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_pages = ceil($row["total"] / $results_per_page);

    // Determine which page number visitor is currently on
    $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $current_page = max(1, min($current_page, $total_pages)); // Ensure current page is within valid range

    // Determine the SQL LIMIT starting number for the results on the displaying page
    $starting_limit = ($current_page - 1) * $results_per_page;
    $starting_limit = max(0, $starting_limit); // Ensure starting limit is non-negative

    // Prepare the main query with search conditions and pagination
    $sql = "SELECT * FROM aft_scrutiny WHERE $conditions LIMIT ?, ?";
    $stmt = $conn->prepare($sql);

    // Add LIMIT and OFFSET as integers at the end of the $params array
    $params[] = $starting_limit;
    $params[] = $results_per_page;
    $types .= 'ii'; // Add two integer placeholders for LIMIT and OFFSET

    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="table-responsive">';
        echo '<table class="table table-bordered table-striped">';
        echo '<thead class="thead-dark">';
        echo '<tr><th>Diary No</th><th>Date of Presentation</th><th>Nature of Document</th><th>Associated With</th><th>Presented By</th><th>Actions</th></tr>';
        echo '</thead><tbody>';
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["diary_no"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["date_of_presentation"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["nature_of_doc"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["associated_with"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["presented_by"]) . "</td>";
            // Make sure to pass all the necessary columns to viewDetails()
            echo '<td><button class="btn btn-info btn-sm" onclick="viewDetails(
                ' . $row["id"] . ', 
                \'' . htmlspecialchars($row["diary_no"]) . '\', 
                \'' . htmlspecialchars($row["date_of_presentation"]) . '\', 
                \'' . htmlspecialchars($row["nature_of_doc"]) . '\', 
                \'' . htmlspecialchars($row["associated_with"]) . '\', 
                \'' . htmlspecialchars($row["presented_by"]) . '\', 
                \'' . htmlspecialchars($row["reviewed_by"]) . '\', 
                \'' . htmlspecialchars($row["nature_of_grievance"]) . '\', 
                \'' . htmlspecialchars($row["nature_of_grievance_code"]) . '\', 
                \'' . htmlspecialchars($row["subject"]) . '\', 
                \'' . htmlspecialchars($row["subject_code"]) . '\', 
                \'' . htmlspecialchars($row["result"]) . '\', 
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
            echo "</tr>";
        }
        
        echo '</tbody></table>';
        echo '</div>';

        // Display pagination
        echo '<nav aria-label="Page navigation">';
        echo '<ul class="pagination justify-content-center">';

        // Previous button
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

        // Next button
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

    // Close connection
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
    <p><strong>Diary No:</strong> <span id="modalDiaryNo"></span></p>
    <p><strong>Date of Presentation:</strong> <span id="modalDateOfPresentation"></span></p>
    <p><strong>Nature of Document:</strong> <span id="modalNatureOfDoc"></span></p>
    <p><strong>Associated With:</strong> <span id="modalAssociatedWith"></span></p>
    <p><strong>Presented By:</strong> <span id="modalPresentedBy"></span></p>
    <p><strong>Reviewed By:</strong> <span id="modalReviewedBy"></span></p>
    <p><strong>Nature of Grievance:</strong> <span id="modalNatureOfGrievance"></span></p>
    <p><strong>Nature of Grievance Code:</strong> <span id="modalNatureOfGrievanceCode"></span></p>
    <p><strong>Result:</strong> <span id="modalResult"></span></p>
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
    <p><strong>Defects:</strong> <span id="modalDefects"></span></p>
    <button id="viewDefectsButton" class="btn btn-warning btn-sm mt-2" onclick="viewDefects()">View Defects</button>
</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printModalContent()">Print</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function printModalContent() {
    // Get all the values from the modal
    var diaryNo = document.getElementById('modalDiaryNo').innerText;
    var dateOfPresentation = document.getElementById('modalDateOfPresentation').innerText;
    var natureOfDoc = document.getElementById('modalNatureOfDoc').innerText;
    var associatedWith = document.getElementById('modalAssociatedWith').innerText;
    var presentedBy = document.getElementById('modalPresentedBy').innerText;
    var reviewedBy = document.getElementById('modalReviewedBy').innerText;
    var natureOfGrievance = document.getElementById('modalNatureOfGrievance').innerText;
    var natureOfGrievanceCode = document.getElementById('modalNatureOfGrievanceCode').innerText;
    var subject = document.getElementById('modalSubject').innerText;
    var subjectCode = document.getElementById('modalSubjectCode').innerText;
    var result = document.getElementById('modalResult').innerText;
    var sectionOfficerRemark = document.getElementById('modalSectionOfficerRemark').innerText;
    var deputyRegistrarRemark = document.getElementById('modalDeputyRegistrarRemark').innerText;
    var registrarRemark = document.getElementById('modalRegistrarRemark').innerText;
    var notCompletedObservations = document.getElementById('modalNotCompletedObservations').innerText;
    var caseType = document.getElementById('modalCaseType').innerText;
    var noOfApplicants = document.getElementById('modalNoOfApplicants').innerText;
    var noOfRespondents = document.getElementById('modalNoOfRespondents').innerText;
    var initial = document.getElementById('modalInitial').innerText;
    var remark = document.getElementById('modalRemark').innerText;
    var caRemark = document.getElementById('modalCaRemark').innerText;
    var notificationRemark = document.getElementById('modalNotificationRemark').innerText;
    var notificationDate = document.getElementById('modalNotificationDate').innerText;
    var natureOfGrievanceOther = document.getElementById('modalNatureOfGrievanceOther').innerText;
    var defects = document.getElementById('modalDefects').innerText;

    // Create a new window for printing
    var printWindow = window.open('', '', 'height=800,width=600');
    printWindow.document.write('<html><head><title>Print Diary Details</title>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h3>Diary Details</h3>');

    // Print all the values from the modal
    printWindow.document.write('<p><strong>Diary No:</strong> ' + diaryNo + '</p>');
    printWindow.document.write('<p><strong>Date of Presentation:</strong> ' + dateOfPresentation + '</p>');
    printWindow.document.write('<p><strong>Nature of Document:</strong> ' + natureOfDoc + '</p>');
    printWindow.document.write('<p><strong>Associated With:</strong> ' + associatedWith + '</p>');
    printWindow.document.write('<p><strong>Presented By:</strong> ' + presentedBy + '</p>');
    printWindow.document.write('<p><strong>Reviewed By:</strong> ' + reviewedBy + '</p>');
    printWindow.document.write('<p><strong>Nature of Grievance:</strong> ' + natureOfGrievance + '</p>');
    printWindow.document.write('<p><strong>Nature of Grievance Code:</strong> ' + natureOfGrievanceCode + '</p>');
    printWindow.document.write('<p><strong>Subject:</strong> ' + subject + '</p>');
    printWindow.document.write('<p><strong>Subject Code:</strong> ' + subjectCode + '</p>');
    printWindow.document.write('<p><strong>Result:</strong> ' + result + '</p>');
    printWindow.document.write('<p><strong>Section Officer Remark:</strong> ' + sectionOfficerRemark + '</p>');
    printWindow.document.write('<p><strong>Deputy Registrar Remark:</strong> ' + deputyRegistrarRemark + '</p>');
    printWindow.document.write('<p><strong>Registrar Remark:</strong> ' + registrarRemark + '</p>');
    printWindow.document.write('<p><strong>Not Completed Observations:</strong> ' + notCompletedObservations + '</p>');
    printWindow.document.write('<p><strong>Case Type:</strong> ' + caseType + '</p>');
    printWindow.document.write('<p><strong>No of Applicants:</strong> ' + noOfApplicants + '</p>');
    printWindow.document.write('<p><strong>No of Respondents:</strong> ' + noOfRespondents + '</p>');
    printWindow.document.write('<p><strong>Initial:</strong> ' + initial + '</p>');
    printWindow.document.write('<p><strong>Remark:</strong> ' + remark + '</p>');
    printWindow.document.write('<p><strong>CA Remark:</strong> ' + caRemark + '</p>');
    printWindow.document.write('<p><strong>Notification Remark:</strong> ' + notificationRemark + '</p>');
    printWindow.document.write('<p><strong>Notification Date:</strong> ' + notificationDate + '</p>');
    printWindow.document.write('<p><strong>Nature of Grievance (Other):</strong> ' + natureOfGrievanceOther + '</p>');
    printWindow.document.write('<p><strong>Defects:</strong> ' + defects + '</p>');

    printWindow.document.write('</body></html>');

    // Close and print the window
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}

</script>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
