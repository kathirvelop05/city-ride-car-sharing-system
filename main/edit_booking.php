<?php
include '../includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Empty password
$dbname = "project";

// Check if booking_id is provided in the URL
if (!isset($_GET['booking_id'])) {
    echo "Error: Booking ID is missing.";
    exit;
}

$booking_id = $_GET['booking_id'];

// Connect to the database
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Start transaction
    $conn->beginTransaction();

    // Retrieve booking details
    $stmt = $conn->prepare("SELECT * FROM booking WHERE booking_id = :booking_id FOR UPDATE");
    $stmt->bindParam(':booking_id', $booking_id);
    $stmt->execute();
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$booking) {
        echo "Error: Booking not found.";
        exit;
    }

    // Check if the logged-in user is the owner of the booking
    if ($_SESSION['user_id'] != $booking['user_id']) {
        echo "Error: You do not have permission to edit this booking.";
        exit;
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get updated booking details
        $new_seats_booked = $_POST['new_seats_booked'];

        // Calculate difference in seats
        $seats_difference = $new_seats_booked - $booking['seats_booked'];

        // Retrieve post details to update available seats
        $stmt = $conn->prepare("SELECT * FROM post_rides WHERE post_id = :post_id FOR UPDATE");
        $stmt->bindParam(':post_id', $booking['post_id']);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if there are enough available seats
        $new_seats_available = $post['seats_available'] - $seats_difference;
        if ($new_seats_available < 0) {
            echo "Error: Not enough seats available.";
            exit;
        }

        // Update booking
        $update_booking_stmt = $conn->prepare("UPDATE booking SET seats_booked = :seats_booked WHERE booking_id = :booking_id");
        $update_booking_stmt->bindParam(':seats_booked', $new_seats_booked);
        $update_booking_stmt->bindParam(':booking_id', $booking_id);
        $update_booking_stmt->execute();

        // Update available seats in post_rides
        $update_post_stmt = $conn->prepare("UPDATE post_rides SET seats_available = :seats_available WHERE post_id = :post_id");
        $update_post_stmt->bindParam(':seats_available', $new_seats_available);
        $update_post_stmt->bindParam(':post_id', $booking['post_id']);
        $update_post_stmt->execute();

        // Commit transaction
        $conn->commit();

        echo "Booking updated successfully!";
    }
} catch(PDOException $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo "Connection failed: " . $e->getMessage();
}

// Close connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}

main {
    top:80px;
    max-width: 600px;
    margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    margin-top: 0;
}

form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="number"] {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button[type="submit"] {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

</style>
<body>
    <main>
    <h2>Edit Booking</h2>
    <form method="post" action="">
        <label for="new_seats_booked">New Seats Booked:</label>
        <input type="number" id="new_seats_booked" name="new_seats_booked" value="<?php echo $booking['seats_booked']; ?>" required><br>

        <button type="submit">Update Booking</button>
    </form>
</main>
</body>
</html>
