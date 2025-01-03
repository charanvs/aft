<?php
require_once dirname(__FILE__) . '/../config/db_connection.php';

$bench = $_GET['bench'] ?? '';

$query = "SELECT * FROM aft_rb_judgement WHERE bench = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $bench);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>
