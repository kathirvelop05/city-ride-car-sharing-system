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
    }

    h1 {
        margin-bottom: 20px;
    }

    .post {
        margin-bottom: 20px;
    }

    h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    p {
        margin-bottom: 5px;
    }

    strong {
        font-weight: bold;
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

    hr {
        margin-top: 20px;
        margin-bottom: 20px;
        border: none;
        border-top: 1px solid #ccc;
    }

</style>
<div class="container">
    <h1>Your Posts</h1>
    <?php
    // Include database connection
    include 'db_connection.php';
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit;
    }

    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Fetch user's posts from the database
    $sql = "SELECT * FROM post_rides WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if there are posts
    if (mysqli_num_rows($result) > 0) {
        // Display posts
        while ($post = mysqli_fetch_assoc($result)) {
            ?>
            <div class="post">
                <h2><?php echo $post['departure'] . ' to ' . $post['destination']; ?></h2>
                <p><strong>Seats Available:</strong> <?php echo $post['seats_available']; ?></p>
                <p><strong>Price:</strong> ₹<?php echo $post['price']; ?></p>
                <p><strong>Date:</strong> <?php echo $post['date']; ?></p>
                <button onclick="window.location.href='edit_post.php?post_id=<?php echo $post['post_id']; ?>'">Edit</button>
                <button onclick="window.location.href='delete_post.php?post_id=<?php echo $post['post_id']; ?>'">Delete</button>
                <hr>
            </div>
            <?php
        }
    } else {
        // No posts found
        echo "No posts found.";
    }
    ?>   <style>
        
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
</div>
