<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get the username and new password entered by the user
    $username = $_POST['username'];
    $newPassword = $_POST['new_password']; // Assuming the name of the input field for new password is 'new_password'

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password in the database
    $sql = "UPDATE users SET password = '$hashedPassword' WHERE username = '$username'";

    if (mysqli_query($conn, $sql)) {
        // Password updated successfully
        mysqli_close($conn);
        echo "<script>alert('Password updated successfully.'); window.location.href = 'index.html';</script>";
        exit;
    } else {
        echo "Error updating password: " . mysqli_error($conn);
    }

    // Close the connection
    mysqli_close($conn);
}
?>
