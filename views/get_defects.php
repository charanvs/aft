<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aft_site";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed."]));
}

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
            echo json_encode(["message" => "Diary no is already registered and Registration no is $registration_no."]);
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
                    "message" => "Judgement has already been pronounced for the case. Registration No is: $disposed_registration_no ",
                    "diary_no" => $disposed_diary_no,
                    "registration_no" => $disposed_registration_no
                ]);
                exit();
            } else {
                // If diary_no is not found in aft_registration and aft_disposedof, return any defects
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
                    echo json_encode($defects);
                } else {
                    echo json_encode(["message" => "No defects found."]);
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
