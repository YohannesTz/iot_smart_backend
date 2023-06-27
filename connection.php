<?php
//Setting header to Json
//header('Content-Type: application/json');

//Connecting to database
$host = "localhost";
$username = "";
$password = "";
$dbname = "";

// Create a mysqli instance
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(array("success" => false, "message" => "Error: " . $conn->connect_error)));
}

return $conn;

?>
