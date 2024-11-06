<?php
// Include database connection
include '../config/database.php';

// Check if the token is provided
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists and is not expired
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid, display the reset password form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Update the user's password in the users table
            $row = $result->fetch_assoc();
            $email = $row['email'];

            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $newPassword, $email);
            if ($stmt->execute()) {
                // Delete the reset token from the password_resets table
                $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();

                echo "Your password has been reset successfully.";
            } else {
                echo "Failed to update your password. Please try again.";
            }
        }
    } else {
        echo "Invalid or expired token.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No token provided.";
}
?>

<!-- HTML Form for Resetting Password -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center mb-3">Reset Password</h4>
                    <form method="POST" action="">
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>