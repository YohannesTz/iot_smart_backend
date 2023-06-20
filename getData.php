<?php

//setting header to Json
header('Content-Type: application/json');


$conn = require 'connection.php';
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    if (isset($_GET['hardwareId']) && !empty($_GET['hardwareId']) && isset($_GET['password']) && !empty($_GET['password'])) {
        $hardwareId = $_GET['hardwareId'];
        $password = $_GET['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Authenticate user
        $stmt = $conn->prepare("SELECT * FROM user WHERE hardwareId = ?");
        $stmt->bind_param("s", $hardwareId); // Encrypt password
        $stmt->execute();
        $result = $stmt->get_result();

        // Authenticate the user
        $authenticated = false;
        while ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $authenticated = true;
                break;
            }
        }

        // Output the data as JSON if authenticated, otherwise output an error message
        if ($authenticated) {
            $sql = "SELECT * FROM sensordata";
            $result = $conn->query($sql);

            $data = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }
            echo json_encode(array("success" => true, "data" => $data));
        } else {
            //echo json_encode("", "Authentication failed");
            echo json_encode(array("success" => false, "message" => "Authentication failed."));
        }

        // Close result set
        $result->close();

        // Close statement
        $stmt->close();
    } else {
        echo json_encode(array("success" => false, "message" => "Error: Missing or empty fields"));
    }
} else {
    $response = array("success" => false, 'message' => 'Server is running and does not accept any operation using this method.');
    echo json_encode($response);
}

?>