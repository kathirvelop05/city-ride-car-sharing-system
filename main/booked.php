<?php include '../includes/header.php';?>
<?php
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login/index.html"); // Redirect to login page if not logged in
    exit;
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Empty password
$dbname = "project";

// Connect to the database
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve bookings for the logged-in user with departure and destination details
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT b.booking_id, b.seats_booked, b.booked_datetime, p.departure, p.destination FROM booking b INNER JOIN post_rides p ON b.post_id = p.post_id WHERE b.user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
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
    <title>My Bookings</title>
</head>
<style>
    /* Resetting default margin and padding */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Body styles */
body {
  font-family: Arial, sans-serif;
  background-color: #f0f0f0;
  margin: 0;
  padding: 0;
}
h2 {
  font-size: 24px;
  margin-bottom: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
}

button {
  background-color: #870b0b; /* Green */
  border: none;
  color: white;
  padding: 8px 16px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin-right: 10px;
  cursor: pointer;
}

button:hover {
  background-color: #f56642;
}

    </style>
<body>
<main>
    <h2>My Bookings</h2>
    <table>
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Departure</th>
                <th>Destination</th>
                <th>Seats Booked</th>
                <th>Booking Date and Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?php echo $booking['booking_id']; ?></td>
                    <td><?php echo $booking['departure']; ?></td>
                    <td><?php echo $booking['destination']; ?></td>
                    <td><?php echo $booking['seats_booked']; ?></td>
                    <td><?php echo $booking['booked_datetime']; ?></td>
                    <td>
                        <button onclick="window.location.href='edit_booking.php?booking_id=<?php echo $booking['booking_id']; ?>'">Edit</button>
                        <button onclick="window.location.href='cancel_booking.php?booking_id=<?php echo $booking['booking_id']; ?>'">Cancel</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
<style>
        /* Styles for the back button */
        .back-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            z-index: 9999; /* Ensure it's on top of other elements */
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>    
<!-- Back button -->
    <button class="back-button" onclick="window.history.back()">Back</button>
</body>
</html>
