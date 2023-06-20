<?php

//setting header to Json
header('Content-Type: application/json');


$conn = require 'connection.php';

$method = $_SERVER['REQUEST_METHOD'];
//$data = json_decode(file_get_contents('php://'), true);

if ($method == 'POST') {
    if (
        isset($_POST['userId']) && !empty($_POST['userId'])
        && isset($_POST['phoneNumber']) && !empty($_POST['phoneNumber'])
        && isset($_POST['feedback']) && !empty($_POST['feedback'])
    ) {
        $userId = $_POST['userId'];
        $phoneNumber = $_POST['phoneNumber'];
        $feedback = $_POST['feedback'];

        $stmt = $conn->prepare("INSERT INTO `feedback`(`id`, `userId`, `phonenumber`, `feedback`) VALUES (null, ?, ?, ?)");
        $stmt->bind_param("iss", $userId, $phoneNumber, $feedback);
        $stmt->execute();

        echo json_encode(array("sucess" => false, "message" => "Successfully inserted feedback"));
        $stmt->close();
    } else {
        // Handle missing or empty fields
        echo json_encode(array("success" => false, "message" => "Error: Missing or empty fields"));
    }
} else {
    $response = array('message' => 'Server is running and does not accept any operation using this method.');
    echo json_encode($response);
}

?>