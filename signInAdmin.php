<?php

//setting header to Json
header('Content-Type: application/json');


$conn = require 'connection.php';


$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        //$hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //Authenticate user
        // Select from admin table where email matches
        $sql = "SELECT * FROM admin WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Email exists, check if password matches
            $row = $result->fetch_assoc();
            if ($password == $row['password']) {
                // Password matches, send success JSON message
                echo json_encode(array("success" => true, "data" => $row, "isAuthenticated" => true, "password" => $password));
            } else {
                // Password does not match, send error JSON message
                echo json_encode(array("success" => false, "data" => null, "isAuthenticated" => false, "password" => $password));
            }
        } else {
            // Email does not exist, send error JSON message
            $response = array('status' => 'error', 'message' => 'Email not found');
            echo json_encode($response);
        }
    }
} else {
    $response = array("success" => false, 'message' => 'Server is running and does not accept any operation using this method.');
    echo json_encode($response);
}

?>