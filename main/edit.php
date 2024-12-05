<!-- Main Home Banner and Input Search Container -->
<div class="position-relative">
    <!-- Add a container to display user's posts -->
    <div class="container mt-5">
        <!-- Check if the user is logged in -->
        <?php
        session_start();
        if (isset($_SESSION['user_id'])) {
            // User is logged in, fetch posts associated with the user from the database
            // Replace 'YOUR_QUERY_TO_FETCH_USER_POSTS' with your actual SQL query
            $userId = $_SESSION['user_id'];
            $sql = "SELECT * FROM posts WHERE user_id = $userId"; // Example query
            // Execute the query and fetch posts
            // Replace this with your database connection and query execution
            $userPosts = []; // Fetch user's posts from the database
            ?>
            <!-- Display the user's posts -->
            <h3>Your Posts</h3>
            <ul class="list-group">
                <?php foreach ($userPosts as $post) { ?>
                    <li class="list-group-item">
                        <!-- Display post details -->
                        <div>Title: <?php echo $post['title']; ?></div>
                        <div>Description: <?php echo $post['description']; ?></div>
                        <!-- Add edit and delete options -->
                        <div>
                            <a href="edit_post.php?post_id=<?php echo $post['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="delete_post.php?post_id=<?php echo $post['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>

    <div>
        <div class="home-banner"></div>
    </div>

    <!-- Input Search Container -->
    <div class="input-search-container">
        <!-- Your existing search form -->
        <!-- ... -->
    </div>
</div>
