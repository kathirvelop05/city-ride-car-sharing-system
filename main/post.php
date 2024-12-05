<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Start the session to access session variables
    session_start();

    // Check if the user is logged in
    if(isset($_SESSION['user_id'])) {
        // Retrieve the user ID of the logged-in user
        $user_id = $_SESSION['user_id'];

        // Validate and sanitize form inputs
        $departure = $_POST['departure'];
        $destination = $_POST['destination'];
        $seats_available = intval($_POST['seats_available']);
        $price = floatval($_POST['price']);
        $date = $_POST['date']; // Assuming date format is valid

        // Check if all required fields are provided and valid
        if ($departure && $destination && $seats_available > 0 && $price > 0 && $date) {
            // Check if seats available is less than or equal to 3
            if ($seats_available <= 3) {
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

                // Prepare SQL statement
                $sql = "INSERT INTO post_rides (user_id, departure, destination, seats_available, price, date) VALUES (?, ?, ?, ?, ?, ?)";

                // Bind parameters
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "isssds", $user_id, $departure, $destination, $seats_available, $price, $date);

                // Execute statement
                if (mysqli_stmt_execute($stmt)) {
                    // Ride posted successfully
                    echo '<script>alert("Ride posted successfully"); window.location.href = "showpost.php";</script>';
                    exit; // Stop further execution
                } else {
                    echo "Error: " . mysqli_error($conn);
                }

                // Close statement and connection
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
            } else {
                // Alert message for seat availability exceeded
                echo '<script>alert("You can only post rides with 3 or fewer available seats."); window.location.href = "posthtml.php";</script>';
            }
        } else {
            echo "Invalid input data. Please make sure all fields are filled correctly.";
        }
    } else {
        echo "User is not logged in.";
    }
}
?>
