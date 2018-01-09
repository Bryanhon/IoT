<!DOCTYPE html>
<html>
<head>
<title>IoT | Sensors</title>
<link rel="stylesheet" type="text/css" href="./css/style.css">
</head>

<body>
	<div class="topnav">
	  <a href="index.html">Home</a>
	  <a class="active" href="sensors.php">Sensors</a>
	  <a href="sensorData.php">Sensor Data</a>
	  <a style="float:right" href="about.html">About</a>
	</div>
	
	<br>
	
<?php
include_once "dbh.php";

echo "<table style='border: solid 1px black; margin: auto;'>";
echo "<tr><th>ID</th><th>Name</th><th>Last seen</th><th>Last known IP</th></tr>";

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
    $stmt = $conn->prepare("SELECT * FROM sensors"); 
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