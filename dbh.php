<?php
// Database credentials
$host = "localhost";
$username = "root";
$password = "";
$dbname = "iot_farm_monitoring";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve data
$sql = "SELECT * FROM dht_new ORDER BY id DESC LIMIT 1";

// Execute query
$result = $conn->query($sql);

// Check if any rows were returned
$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
 else {
    echo "0 results";
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($data);
// Close connection

?>