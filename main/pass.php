<?php
require_once 'db_connection.php'; // Include your database connection script
include '../includes/header.php';
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to change your password.";
    exit();
}

// Get the user ID from the session
$userID = $_SESSION['user_id'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate if new password and confirm password match
    if ($newPassword === $confirmPassword) {
        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $sql = "UPDATE users SET password = '$hashedPassword' WHERE userID = $userID";

        if (mysqli_query($conn, $sql)) {
            echo "Password updated successfully.";
        } else {
            echo "Error updating password: " . mysqli_error($conn);
        }
    } else {
        echo "New password and confirm password do not match.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>
<style>
    main{
        top:80px;
        position:absolute;
        border: 5px solid;
        margin-left:30%;
  width: 500px;
  padding: 10px;
    }
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

main {
    width: 400px;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-top: 50px;
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

</style>
<body>
    <main>
    <h2>Change Password</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="newPassword">New Password:</label>
        <input type="password" name="newPassword" id="newPassword" required><br><br>
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" name="confirmPassword" id="confirmPassword" required><br><br>
        <input type="submit" value="Change Password">
    </form>
</main>
</body>
</html>
