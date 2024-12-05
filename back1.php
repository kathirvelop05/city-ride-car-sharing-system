<?php
session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection parameters
    $servername = "localhost";
    $user = "root";
    $password = "";
    $dbname = "project";

    // Create connection
    $conn = mysqli_connect($servername, $user, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['pass']; // Note: In a real-world scenario, you should hash the password for security

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to retrieve the hashed password from the database
    $sql = "SELECT userID, password FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Fetch user data from the result
        $row = mysqli_fetch_assoc($result);
        $userID = $row['userID'];
        $hashedPasswordFromDB = $row['password'];

        // Verify the password
        if (password_verify($password, $hashedPasswordFromDB)) {
            // Password is correct, store user ID in session
            $_SESSION['user_id'] = $userID;

            // Redirect user to another page (e.g., dashboard.php)
            header("Location: ../main/index.php");
            exit;
        } else {
            // Password is incorrect, display error message
            echo '<script>
                    alert("Invalid username or password");
                    window.location.href = "index.html?login_status=failed";
                  </script>';
            exit;
        }
    } else {
        // Username not found, display error message
        echo '<script>
                alert("Invalid username or password");
                window.location.href = "index.html?login_status=failed";
              </script>';
        exit;
    }

    // Close the connection
    mysqli_close($conn);
}
?>
