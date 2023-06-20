<?php

//setting header to Json
header('Content-Type: application/json');


$conn = require 'connection.php';


$method = $_SERVER['REQUEST_METHOD'];
//$data = json_decode(file_get_contents('php://'), true);

if ($method == 'POST') {
    if (isset($_GET['hardwareId']) && !empty($_GET['hardwareId']) && isset($_GET['password']) && !empty($_GET['password'])) {
        $hardwareId = $_GET['hardwareId'];
        $password = $_GET['password'];

        // Authenticate User
        $stmt = $conn->prepare("SELECT * FROM User WHERE password = ?");
        $stmt->bind_param("s", password_hash($password, PASSWORD_DEFAULT)); // Encrypt password
        $stmt->execute();
        $result = $stmt->get_result();

        // Authenticate the user
        $authenticated = false;
        while ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password_hash'])) {
                $authenticated = true;
                break;
            }
        }

        if ($authenticated) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            echo json_encode(array("success" => true, "data" => $data));
        } else {
            echo json_encode(array("success" => false, "message" => "Authentication failed."));
        }

        $result->close();
        $stmt->close();
    }
} else {
    $response = array('message' => 'Server is running and does not accept any operation using this method.');
    echo json_encode($response);
}

?>