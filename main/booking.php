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

// Check if post_id is provided in the URL
if (!isset($_GET['post_id'])) {
    echo "<script>alert('Error: Post ID is missing.'); window.location.href = 'index.php';</script>";
    exit;
}

$post_id = $_GET['post_id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get number of seats to book
    $seats_to_book = $_POST['seats_to_book'];

    // Connect to the database
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Start a transaction
        $conn->beginTransaction();

        // Retrieve ride details from post_rides table
        $stmt = $conn->prepare("SELECT * FROM post_rides WHERE post_id = :post_id FOR UPDATE");
        $stmt->bindParam(':post_id', $post_id);
        $stmt->execute();
        $ride = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ride) {
            echo "<script>alert('Error: Ride not found.'); window.location.href = 'index.php';</script>";
            exit;
        }

        // Check if there are enough available seats
        if ($ride['seats_available'] >= $seats_to_book) {
            // Update available seats
            $new_seats_available = $ride['seats_available'] - $seats_to_book;
            $update_stmt = $conn->prepare("UPDATE post_rides SET seats_available = :seats_available WHERE post_id = :post_id");
            $update_stmt->bindParam(':seats_available', $new_seats_available);
            $update_stmt->bindParam(':post_id', $post_id);
            $update_stmt->execute();

            // Insert booking details into booking table
            $user_id = $_SESSION['user_id'];
            $current_datetime = date("Y-m-d H:i:s");
            $insert_stmt = $conn->prepare("INSERT INTO booking (user_id, post_id, seats_booked, booked_datetime) VALUES (:user_id, :post_id, :seats_booked, :booked_datetime)");
            $insert_stmt->bindParam(':user_id', $user_id);
            $insert_stmt->bindParam(':post_id', $post_id);
            $insert_stmt->bindParam(':seats_booked', $seats_to_book);
            $insert_stmt->bindParam(':booked_datetime', $current_datetime);
            $insert_stmt->execute();

            // Commit the transaction
            $conn->commit();

            echo "<script>alert('Booking successful!');</script>";
        } else {
            echo "<script>alert('Error: Not enough seats available.');</script>";
        }
    } catch(PDOException $e) {
        // Rollback the transaction on error
        $conn->rollback();
        echo "<script>alert('Connection failed: " . $e->getMessage() . "');</script>";
    }

    // Close connection
    $conn = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        main {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-top: 0;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        input[type="number"] {
            padding: 8px;
            width: 100%;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            background-color: #13aa52;
  border: 1px solid #13aa52;
  border-radius: 4px;
  box-shadow: rgba(0, 0, 0, .1) 0 2px 4px 0;
  box-sizing: border-box;
  color: #fff;
  cursor: pointer;
  font-family: "Akzidenz Grotesk BQ Medium", -apple-system, BlinkMacSystemFont, sans-serif;
  font-size: 16px;
  font-weight: 400;
  outline: none;
  outline: 0;
  padding: 10px 25px;
  text-align: center;
  transform: translateY(0);
  transition: transform 150ms, box-shadow 150ms;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
        }

        button:hover {
            box-shadow: rgba(0, 0, 0, .15) 0 3px 9px 0;
  transform: translateY(-2px);
        }
        @media (min-width: 768px) {
  .button {
    padding: 10px 30px;
  }
}
    </style>
<body>
    <main>
    <h2>Booking Seats</h2>
    <form method="post" action="">
        <label for="seats_to_book">Seats to Book:</label>
        <input type="number" id="seats_to_book" name="seats_to_book" min="1" required>
        <button type="submit">Book</button>
    </form>
</main>
</body>
</html>
