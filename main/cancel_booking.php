<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Check if booking_id is provided in the URL
if (!isset($_GET['booking_id'])) {
    echo "Error: Booking ID is missing.";
    exit;
}

$booking_id = $_GET['booking_id'];

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Empty password
$dbname = "project";

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve booking details
    $stmt = $conn->prepare("SELECT * FROM booking WHERE booking_id = :booking_id");
    $stmt->bindParam(':booking_id', $booking_id);
    $stmt->execute();
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$booking) {
        echo "Error: Booking not found.";
        exit;
    }

    // Check if the logged-in user is the owner of the booking
    if ($_SESSION['user_id'] != $booking['user_id']) {
        echo "Error: You do not have permission to cancel this booking.";
        exit;
    }

    // Update seats available in post_rides table
    $stmt = $conn->prepare("UPDATE post_rides SET seats_available = seats_available + :seats_booked WHERE post_id = :post_id");
    $stmt->bindParam(':seats_booked', $booking['seats_booked']);
    $stmt->bindParam(':post_id', $booking['post_id']);
    $stmt->execute();

    // Delete the booking
    $delete_stmt = $conn->prepare("DELETE FROM booking WHERE booking_id = :booking_id");
    $delete_stmt->bindParam(':booking_id', $booking_id);
    $delete_stmt->execute();

    echo "Booking canceled successfully!";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Close connection
$conn = null;
?>
