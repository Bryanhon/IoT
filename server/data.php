<?php
include_once "dbh.php";

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

header('Content-Type: application/json');

$start 	= mysqli_real_escape_string($conn, $_GET["startDate"]);
$end 	= mysqli_real_escape_string($conn, $_GET["endDate"]);

$query = "SELECT * FROM sensorData WHERE timedate BETWEEN ? AND ? ORDER BY timedate;";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $start, $end);
$stmt->execute();

$stmt->bind_result($ID, $timedate, $value);
$result = array();

while ($stmt->fetch()) {
	$result[] = array("ID"=>$ID, "timedate"=>$timedate, "value"=>$value);
}

$stmt->close();
$conn->close();

echo json_encode($result);