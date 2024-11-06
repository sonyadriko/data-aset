<?php
// Include your database connection
require '../config/database.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT id FROM user WHERE username = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));

        // Store the token in the database with an expiration date (e.g., 1 hour from now)
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));
        $stmt = $conn->prepare("UPDATE user SET reset_token = ?, token_expiry = ? WHERE username = ?");
        $stmt->bind_param("sss", $token, $expiry, $email);
        $stmt->execute();

        // Send the reset link to the user's email
        $reset_link = "http://yourwebsite.com/reset_password.php?token=" . $token;
        $subject = "Password Reset Request";
        $message = "Click the link below to reset your password:\n" . $reset_link;
        $headers = "From: no-reply@yourwebsite.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "A password reset link has been sent to your email.";
        } else {
            echo "Failed to send the email. Please try again later.";
        }
    } else {
        echo "No account found with that email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <p>Enter your email address to receive a password reset link.</p>
        <form action="send_reset_link.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Send Reset Link</button>
        </form>
    </div>
</body>

</html>