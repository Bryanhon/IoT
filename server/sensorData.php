<!DOCTYPE html>
<html>
<head>
<title>IoT | Sensor Data</title>
<link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<body>
	<div class="topnav">
	  <a href="index.html">Home</a>
	  <a href="sensors.php">Sensors</a>
	  <a class="active" href="sensorData.php">Sensor Data</a>
	  <a style="float:right" href="about.html">About</a>
	</div>
	
	<br>
	
<?php
include_once "dbh.php";

echo "<table style='border: solid 1px black; margin: auto;'>";
echo "<tr><th>ID</th><th>Date</th><th>Value</th></tr>";

class TableRows extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td style='width: AUTO; border: 1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() { 
        echo "<tr>"; 
    } 

    function endChildren() { 
        echo "</tr>" . "\n";
    } 
} 

try {
    $conn = new PDO("mysql:host=$DB_NAME;dbname=$DB_NAME", $DB_USER, $DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM sensorData WHERE `timedate` >= NOW() - INTERVAL 1 DAY ORDER BY `timedate` DESC"); 
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
        echo $v;
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
?> 

</body>
</html>