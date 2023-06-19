<?php

//setting header to Json
header('Content-Type: application/json');


$conn = require 'connection.php';

if ($mthod == 'GET') {
    // Handle GET request for /users
    if ($_SERVER['REQUEST_URI'] == '/users' && $_SERVER['REQUEST_METHOD'] == 'GET') {
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

        $users = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }

        echo json_encode(array("success" => true, "data" => $users));
    }

    // Handle GET request for /feedback
    if ($_SERVER['REQUEST_URI'] == '/feedback' && $_SERVER['REQUEST_METHOD'] == 'GET') {
        $sql = "SELECT * FROM feedback";
        $result = $conn->query($sql);

        $feedback = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $feedback[] = $row;
            }
        }

        echo json_encode(array("success" => true, "data" => $feedback));
    }
} else {
    $response = array('message' => 'Server is running and does not accept any operation using this method.');
    echo json_encode($response);
}

?>