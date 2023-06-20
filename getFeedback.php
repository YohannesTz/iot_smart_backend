<?php

//setting header to Json
header('Content-Type: application/json');


$conn = require 'connection.php';
$method = $_SERVER['REQUEST_METHOD'];

// Handle GET request for /users and /feedback
$server_uri_users = "/proj/getFeedback.php/users";
$server_uri_feedback = "/proj/getFeedback.php/feedback";


if ($method == 'GET') {

    if ($_SERVER['REQUEST_URI'] == $server_uri_users && $_SERVER['REQUEST_METHOD'] == 'GET') {
        $sql = "SELECT id, email, hardwareId FROM user";
        $result = $conn->query($sql);

        $users = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }

            echo json_encode(array("success" => true, "data" => $users));
        } else {
            echo json_encode(array("success" => true, "data" => []));
        }
    }

    // Handle GET request for /feedback
    if ($_SERVER['REQUEST_URI'] == $server_uri_feedback && $_SERVER['REQUEST_METHOD'] == 'GET') {
        $sql = "SELECT * FROM feedback";
        $result = $conn->query($sql);

        $feedback = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $feedback[] = $row;
            }

            echo json_encode(array("success" => true, "data" => $feedback));
        } else {
            echo json_encode(array("success" => true, "data" => []));
        }
    }
} else {
    $response = array("success" => false, 'message' => 'Server is running and does not accept any operation using this method.');
    echo json_encode($response);
}

?>