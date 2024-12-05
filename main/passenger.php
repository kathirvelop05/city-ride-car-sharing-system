<?php
include '../includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit;
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Empty password
$dbname = "project";

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the logged-in user has posted a ride
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT * FROM post_rides WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $ride = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ride) {
        // If the user has posted a ride, retrieve booking details
        $stmt = $conn->prepare("SELECT b.seats_booked, b.booked_datetime, u.fullName, u.dateOfBirth, u.gender, u.email, u.phoneNumber, u.district
                                FROM booking b
                                JOIN users u ON b.user_id = u.userID
                                WHERE b.post_id = :post_id");
        $stmt->bindParam(':post_id', $ride['post_id']);
        $stmt->execute();
        $passenger_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // If the user has not posted a ride, display a message
        echo "You haven't posted any rides.";
        exit;
    }
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
    <title>Passenger Details</title>
</head>
<body>
    <main>
    <h2>Passenger Details</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Seats Booked</th>
                <th>Booked Datetime</th>
                <th>User Full Name</th>
                <th>Date of Birth</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>District</th>
                <th>Ride Details</th> <!-- New column for the button -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($passenger_details as $passenger): ?>
            <tr>
                <td><?php echo $passenger['seats_booked']; ?></td>
                <td><?php echo $passenger['booked_datetime']; ?></td>
                <td><?php echo $passenger['fullName']; ?></td>
                <td><?php echo $passenger['dateOfBirth']; ?></td>
                <td><?php echo $passenger['gender']; ?></td>
                <td><?php echo $passenger['email']; ?></td>
                <td><?php echo $passenger['phoneNumber']; ?></td>
                <td><?php echo $passenger['district']; ?></td>
                <td><a href="ride_details.php?post_id=<?php echo $ride['post_id']; ?>">Ride Details</a></td> <!-- Link to ride details page -->
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
            </main>
            <style>
                body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
}

main {
    top:80px;
    max-width: 1000px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    margin-top: 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
}

table th {
    background-color: #007bff;
    color: #fff;
}

table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tbody tr:hover {
    background-color: #ddd;
}

.back-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    z-index: 9999; /* Ensure it's on top of other elements */
    transition: background-color 0.3s ease;
}

.back-button:hover {
    background-color: #0056b3;
}

    </style>    
<!-- Back button -->
    <button class="back-button" onclick="window.history.back()">Back</button>
</body>
</html>
