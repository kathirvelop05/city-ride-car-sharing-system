<?php
// Include database connection
include 'db_connection.php';

// Start session
session_start();

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
    echo "Post not found or you do not have permission to delete this post.";
    exit;
}

// Fetch post details
$post = mysqli_fetch_assoc($result);

// Check if confirmation is submitted for deleting post
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
    // Delete post from the database
    $delete_sql = "DELETE FROM post_rides WHERE post_id=?";
    $delete_stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_bind_param($delete_stmt, "i", $post_id);
    $success = mysqli_stmt_execute($delete_stmt);

    if ($success) {
        // Deletion successful
        header("Location: view_post.php");
        exit;
    } else {
        // Deletion failed
        echo "Error deleting post. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Post</title>
</head>
<body>
    <h1>Delete Post</h1>
    <p>Are you sure you want to delete this post?</p>
    <p><strong>Departure:</strong> <?php echo htmlspecialchars($post['departure']); ?></p>
    <p><strong>Destination:</strong> <?php echo htmlspecialchars($post['destination']); ?></p>
    <p><strong>Seats Available:</strong> <?php echo htmlspecialchars($post['seats_available']); ?></p>
    <p><strong>Price:</strong> <?php echo htmlspecialchars($post['price']); ?></p>
    <p><strong>Date:</strong> <?php echo htmlspecialchars($post['date']); ?></p>
    <form method="POST">
        <input type="submit" name="confirm_delete" value="Confirm Delete">
    </form>
</body>
</html>
