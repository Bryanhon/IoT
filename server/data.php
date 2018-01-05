<?php
//setting header to json
header('Content-Type: application/json');

//get URL variables


//database
define('DB_HOST', 'localhost');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('DB_NAME', '');

//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}

//query to get data from the table
if (isset($_GET["startDate"]) && isset($_GET["endDate"]))
	$query = sprintf("SELECT * FROM sensorData WHERE timedate BETWEEN \"%s\" AND \"%s\" ORDER BY timedate;", $_GET["startDate"], $_GET["endDate"]);
else
	$query = sprintf("SELECT * FROM sensorData ORDER BY timedate;");

//execute query
$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
echo json_encode($data);