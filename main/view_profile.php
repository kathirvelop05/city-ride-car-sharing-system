<?php
// Include database connection
include 'db_connection.php';

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Check if form is submitted for updating profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form inputs
    $userID = $_POST['userID'];
    $fullName = $_POST['fullName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $district = $_POST['district'];

    // Update user details in the database
    $update_sql = "UPDATE users SET fullName=?, dateOfBirth=?, gender=?, email=?, phoneNumber=?, district=? WHERE userID=?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "ssssssi", $fullName, $dateOfBirth, $gender, $email, $phoneNumber, $district, $userID);
    $success = mysqli_stmt_execute($update_stmt);

    if ($success) {
        // Update successful
        header("Location: viewprofile.php");
        exit;
    } else {
        // Update failed
        echo "Error updating profile. Please try again.";
    }
} else {
    // Redirect to view profile page if form is not submitted
    header("Location: view_profile.php");
    exit;
}
?>
