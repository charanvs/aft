<?php
// Set the response header to JSON
header('Content-Type: application/json');

// Include the database connection
require_once dirname(__FILE__).'/../config/db_connection.php';

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
                "diary_no" => $diary_no,
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
                    "diary_no" => $disposed_diary_no,
                    "registration_no" => $disposed_registration_no,
                    "message" => "Judgement for RegNo is: $disposed_registration_no pronounced."
                ]);
                exit();
            } else {
                // Check for defects in aft_notifications if not found in aft_registration or aft_disposedof
                $sql = "SELECT defect, rectified_by, nature, time_granted, rectified FROM aft_notifications WHERE sid = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $sid);
                $stmt->execute();
                $result = $stmt->get_result();

                $defects = [];
                while ($row = $result->fetch_assoc()) {
                    // Fetch all fields from aft_notifications
                    $defects[] = [
                        "defect" => $row['defect'],
                        "rectified_by" => $row['rectified_by'],
                        "nature" => $row['nature'],
                        "time_granted" => $row['time_granted'],
                        "rectified" => $row['rectified']
                    ];
                }

                if (!empty($defects)) {
                    // Return the defects and other relevant information in the response
                    echo json_encode([
                        "diary_no" => $diary_no,
                        "defects" => $defects
                    ]);
                } else {
                    // If no defects are found
                    echo json_encode([
                        "diary_no" => $diary_no,
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
