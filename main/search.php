<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Rides</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .main {
            margin: 20px;
        }

        .ride {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }

        .ride h3 {
            margin-top: 0;
            margin-bottom: 5px;
        }

        .ride p {
            margin-top: 0;
            margin-bottom: 5px;
        }

        .ride a {
            text-decoration: none;
            color: #333;
        }

        .ride a:hover {
            text-decoration: underline;
        }

        .ride button {
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

        .ride button:hover {
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
<?php include '../includes/header.php';?>
    <div class="main">
        <?php
        // Assuming you have a session started and a way to identify the logged-in user
        $loggedInUserId = $_SESSION['user_id'] ?? null; // Adjust based on your session management

        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = ""; // Empty password
        $dbname = "project";

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get values from the form
            $departure = $_POST['departure'];
            $destination = $_POST['destination'];
            $date = $_POST['date'];

            try {
                // Create connection
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Prepare SQL statement
                // Exclude rides posted by the logged-in user
                $sql = "SELECT post_id, departure, destination, seats_available, price, date FROM post_rides WHERE departure = :departure AND destination = :destination AND date = :date";
                if ($loggedInUserId) {
                    $sql .= " AND user_id != :loggedInUserId";
                }
                
                $stmt = $conn->prepare($sql);

                // Bind parameters
                $stmt->bindParam(':departure', $departure);
                $stmt->bindParam(':destination', $destination);
                $stmt->bindParam(':date', $date);
                if ($loggedInUserId) {
                    $stmt->bindParam(':loggedInUserId', $loggedInUserId);
                }

                // Execute the query
                $stmt->execute();

                // Fetch all matching rows
                $rides = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Output the results
                if (count($rides) > 0) {
                    echo "<h2>Available Rides</h2>";
                    foreach ($rides as $ride) {
                        if ($ride['seats_available'] > 0) {
                            echo "<div class='ride'>";
                            echo "<h3>{$ride['departure']} to {$ride['destination']}</h3>";
                            echo "<p>Seats Available: {$ride['seats_available']}</p>";
                            echo "<p>One Seat Price: {$ride['price']}</p>";
                            echo "<p>Date: {$ride['date']}</p>";
                            echo "<a href='booking.php?post_id={$ride['post_id']}'><button>Book</button></a>";
                            echo "</div>";
                        }
                        else {
                            echo "<p>No rides available for the selected criteria.</p>";
                        }
                    }
                } else {
                    echo "<p>No rides available for the selected criteria.</p>";
                }
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }

            // Close connection
            $conn = null;
        }
        ?>
    </div>
</body>
</html>
