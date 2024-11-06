<?php
include '../config/database.php';
session_start();

header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$response = array('success' => false, 'message' => 'Invalid request');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

        // Check if the email already exists
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $response['message'] = 'Email already exists. Please use a different email.';
        } else {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $password);

            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Registration successful.';
            } else {
                $response['message'] = 'Registration failed. Please try again.';
            }
        }

        $stmt->close();
        $conn->close();
    } else {
        $response['message'] = 'Email and Password are required.';
    }
}

echo json_encode($response);