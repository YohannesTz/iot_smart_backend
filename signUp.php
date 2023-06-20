<?php

//setting header to Json
header('Content-Type: application/json');


$conn = require 'connection.php';

$method = $_SERVER['REQUEST_METHOD'];
//$data = json_decode(file_get_contents('php://'), true);

if ($method == 'POST') {
    if (
        isset($_POST['email']) && !empty($_POST['email'])
        && isset($_POST['password']) && !empty($_POST['password'])
        && isset($_POST['hardwareId']) && !empty($_POST['hardwareId'])
    ) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hardwareId = password_hash($_POST('hardwareId'), PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO `user`(`id`, `email`, `password`, `hardwareId`) VALUES (null, ?, ?,?)");
        $stmt->bind_param("sss", $email, $password, $hardwareId);
        $stmt->execute();

        echo json_encode(array("success" => false, "message" => "Successfully inserted User"));

        // Close statement
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