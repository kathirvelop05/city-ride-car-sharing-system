<?php
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

    // Get values from the form
    $fullName = $_POST["fullName"];
    $dateOfBirth = date("Y-m-d", strtotime($_POST["dateOfBirth"])); // Convert date format to MySQL format
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phoneNumber"];
    $district = $_POST["district"];
    $username = $_POST["username"];
    $password = $_POST["password"]; // Get the password

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert values into the database with hashed password
    $sql = "INSERT INTO users (fullName, dateOfBirth, gender, email, phoneNumber, district, username, password) 
            VALUES ('$fullName', '$dateOfBirth', '$gender', '$email', '$phoneNumber', '$district', '$username', '$hashedPassword')";
    
    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo "<script>window.location.href = 'index.html';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the connection
    mysqli_close($conn);
}
?>
