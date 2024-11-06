<?php 
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ID from the URL
    $id = $_GET['id'];

    // Prepare the SQL update statement to set deleted_at to the current timestamp
    $query = "UPDATE data_aset SET deleted_at = NOW() WHERE no = ?";
    
    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'i', $id);
    
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "Record marked as deleted successfully.";
    } else {
        echo "Error marking record as deleted: " . mysqli_error($conn);
    }
    
    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);
?>