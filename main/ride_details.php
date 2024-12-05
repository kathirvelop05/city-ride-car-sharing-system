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
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    margin-top: 0;
    color: #007bff; /* Blue color for headings */
}

p {
    margin: 10px 0;
}

button {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3; /* Darker shade on hover */
}
    </style>
<main><?php
include '../includes/header.php';

// Check if post_id is provided in the URL
if (!isset($_GET['post_id'])) {
    echo "Error: Post ID is missing.";
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

    // Retrieve ride details based on post_id
    $post_id = $_GET['post_id'];
    $stmt = $conn->prepare("SELECT * FROM post_rides WHERE post_id = :post_id");
    $stmt->bindParam(':post_id', $post_id);
    $stmt->execute();
    $ride = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ride) {
        echo "Error: Ride not found.";
        exit;
    }

    // Display ride details
    echo "<h2>Ride Details</h2>";
    echo "<p><strong>Departure:</strong> " . $ride['departure'] . "</p>";
    echo "<p><strong>Destination:</strong> " . $ride['destination'] . "</p>";
    echo "<p><strong>Price:</strong> " . $ride['price'] . "</p>";
    echo "<p><strong>Date:</strong> " . $ride['date'] . "</p>";
    echo "<p><strong>Created At:</strong> " . $ride['created_at'] . "</p>";

    // Add a back button
    echo "<button onclick=\"window.history.back()\">Back</button>";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Close connection
$conn = null;
?>
</main>
