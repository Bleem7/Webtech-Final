<?php
header('Content-Type: application/json');

include_once '../settings/connection.php';


$sql = "SELECT * FROM Tasks";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$tasks = array();

while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

$stmt->close();

echo json_encode($tasks);