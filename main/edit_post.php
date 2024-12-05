<?php
// Include database connection
include 'db_connection.php';
include '../includes/header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Check if post_id is provided in URL
if (!isset($_GET['post_id'])) {
    // Redirect to view posts page
    header("Location: view_posts.php");
    exit;
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Get post ID from URL parameter
$post_id = $_GET['post_id'];

// Fetch post details from the database
$sql = "SELECT * FROM post_rides WHERE post_id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $post_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if post exists
if (mysqli_num_rows($result) == 0) {
    // Post not found or user does not have permission
    echo "Post not found or you do not have permission to edit this post.";
    exit;
}

// Fetch post details
$post = mysqli_fetch_assoc($result);

// Check if form is submitted for updating post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form inputs
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    $seats_available = intval($_POST['seats_available']);
    $price = floatval($_POST['price']);
    $date = $_POST['date']; // Assuming date format is valid

    // Update post details in the database
    $update_sql = "UPDATE post_rides SET departure=?, destination=?, seats_available=?, price=?, date=? WHERE post_id=?";
    $update_stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "ssidsi", $departure, $destination, $seats_available, $price, $date, $post_id);
    $success = mysqli_stmt_execute($update_stmt);

    if ($success) {
        // Update successful
        echo "<div>Post updated successfully. Redirecting...</div>";
        echo "<script>setTimeout(function() { window.location.href = 'showpost.php'; }, 2000);</script>";
        exit;
    } else {
        // Update failed
        echo "Error updating post. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        main {
            top:80px;
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #870b0b;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #f56642;
        }
    </style>
<body>
    <main>
    <h1>Edit Post</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?post_id=" . $post_id); ?>">
        <label for="departure">Departure:</label>
        <input type="text" id="departure" name="departure" value="<?php echo htmlspecialchars($post['departure']); ?>" required><br><br>

        <label for="destination">Destination:</label>
        <input type="text" id="destination" name="destination" value="<?php echo htmlspecialchars($post['destination']); ?>" required><br><br>

        <label for="seats_available">Seats Available:</label>
        <input type="number" id="seats_available" name="seats_available" value="<?php echo htmlspecialchars($post['seats_available']); ?>" required><br><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($post['price']); ?>" required><br><br>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($post['date']); ?>" required><br><br>

        <input type="submit" value="Save">
    </form>
</main>
</body>
</html>
