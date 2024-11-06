<?php
include '../config/database.php';
session_start();

header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$response = array('success' => false, 'message' => 'Invalid request');

if (isset($_SESSION['id_users'], $_SESSION['nama'])) {
    $response['success'] = true;
    $response['message'] = 'Already logged in';
    $response['redirect'] = 'dashboard.php';
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Start output buffering
        ob_start();

        $email = $_POST['email'];
        $password = $_POST['password']; // Get the raw password

        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Clear the buffer to ensure no extraneous output
        ob_end_clean();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            // Verify the password using password_verify
            if (password_verify($password, $row['password'])) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $row['username'];

                $response['success'] = true;
                $response['message'] = 'Login successful';
            } else {
                $response['message'] = 'Email or Password is incorrect';
            }
        } else {
            $response['message'] = 'Email or Password is incorrect';
        }

        $stmt->close();
        $conn->close();
    } else {
        $response['message'] = 'Email and Password are required';
    }
}

echo json_encode($response);
error_log("Entered Password: " . $password);