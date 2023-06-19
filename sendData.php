<?php

//setting header to Json
header('Content-Type: application/json');

$conn = require 'connection.php';

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true);

if ($method == 'POST') {
    if (
        isset($_POST['hardwareId']) && !empty($_POST['hardwareId']) && isset($_POST['temp']) && !empty($_POST['temp']) && isset($_POST['humidity']) && !empty($_POST['humidity'])
        && isset($_POST['temp']) && !empty($_POST['temp'])
        && isset($_POST['humidity']) && !empty($_POST['humidity'])
        && isset($_POST['pumpstatus']) && !empty($_POST['pumpstatus'])
    ) {
        //Getting the data
        $hardwareId = $_POST['hardwareId'];
        $temp = $_POST['temp'];
        $humidity = $_POST['humidity'];
        $pumpstatus = $_POST['pumpstatus'] ? 1 : 0;
        $timestamp = time();

        $stmt = $conn->prepare("INSERT INTO `sensordata`(`id`, `hardwaredId`, `temp`, `humidity`, `pumpstatus`, `timestamp`) VALUES (null, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siiis", $hardwareId, $temp, $humidity, $pumpstatus, $timestamp);
        $stmt->execute();

        echo json_encode(array("success" => true, "message" => "Data was successfully inserted."));
        $stmt->close();
    } else {
        echo json_encode(array("success" => false, "message" => "Something was wrong..."));
    }
} else {
    $response = array('message' => 'Server is running and does not accept any operation using this method.');
    echo json_encode($response);
}

?>