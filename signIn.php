<?php

//setting header to Json
header('Content-Type: application/json');


$conn = require 'connection.php';


$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //Authenticate user
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email); // Encrypt password
        $stmt->execute();
        $result = $stmt->get_result();

        $authenticated = false;
        while ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $authenticated = true;
                break;
            }
        }

        // Output the data as JSON if authenticated, otherwise output an error message
        if ($authenticated) {
            $sql = "SELECT * FROM user";
            $result = $conn->query($sql);

            $data = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
            }

            echo json_encode(array("success" => true, "data" => $data[0], "isAuthenticated" => true, "password" => $password));
        } else {
            //echo json_encode("", "Authentication failed");
            echo json_encode(array("success" => false, "message" => "Authentication failed.", "data" => null, "isAuthenticated" => false, "password" => null));
        }
    }
} else {
    $response = array("success" => false, 'message' => 'Server is running and does not accept any operation using this method.');
    echo json_encode($response);
}

?>