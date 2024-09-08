<?php
// Include the database connection
require_once dirname(__FILE__).'/../config/db_connection.php';

// Get the `sid` from the request
$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

if ($sid > 0) {
    // Fetch the diary_no for the given `sid` from aft_scrutiny
    $sql = "SELECT diary_no FROM aft_scrutiny WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $sid);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $diary_no = trim($row['diary_no']);

        // Check if the diary_no exists in aft_registration
        $sql = "SELECT registration_no FROM aft_registration WHERE TRIM(diaryno) = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $diary_no);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $reg_row = $result->fetch_assoc();
            $registration_no = $reg_row['registration_no'];

            // Return the registration_no and message
            echo json_encode([
                "diary_no" => $diary_no,  // Include the diary_no
                "message" => "Diary no is already registered and Registration no is $registration_no."
            ]);
            exit();
        } else {
            // Check if the diary_no exists in aft_disposedof
            $sql = "SELECT diaryno, regno FROM aft_disposedof WHERE TRIM(diaryno) = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $diary_no);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Fetch the details from aft_disposedof
                $disposed_row = $result->fetch_assoc();
                $disposed_diary_no = $disposed_row['diaryno'];
                $disposed_registration_no = $disposed_row['regno'];

                // Return message about the judgement being pronounced
                echo json_encode([
                    "diary_no" => $disposed_diary_no,  // Include the diary_no
                    "registration_no" => $disposed_registration_no,
                    "message" => "Judgement has already been pronounced for the case. Registration No is: $disposed_registration_no."
                ]);
                exit();
            } else {
                // Check for defects in aft_notifications if not found in aft_registration or aft_disposedof
                $sql = "SELECT defect FROM aft_notifications WHERE sid = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $sid);
                $stmt->execute();
                $result = $stmt->get_result();

                $defects = [];
                while ($row = $result->fetch_assoc()) {
                    $defects[] = $row['defect']; // Assuming 'defect' is the column name
                }

                if (!empty($defects)) {
                    echo json_encode([
                        "diary_no" => $diary_no,  // Include the diary_no
                        "defects" => $defects
                    ]);
                } else {
                    // If no records are found in aft_registration, aft_disposedof, or aft_notifications
                    echo json_encode([
                        "diary_no" => $diary_no,  // Include the diary_no
                        "message" => "It seems that the diary no is not scrutinized as yet."
                    ]);
                }
                exit();
            }
        }
    } else {
        echo json_encode(["error" => "Invalid SID or diary number not found."]);
    }
} else {
    echo json_encode(["error" => "Invalid SID."]);
}

$conn->close();
?>
