<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <!-- Responsive Meta Tag -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Adding Bootstrap CDN - Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <!-- Adding Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous" />
        <link rel="stylesheet" type="text/css" href="../main/css/app.css" />
    <title>CITY RIDE</title>
</head>
<style>
        .uploaded-image {
            border-radius: 50%; /* Applying border radius of 50% */
        }
    </style>
<body>
<nav class="navbar navbar-expand-md bg-danger navbar-dark fixed-top">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="#">
                <img src="../main/img/city.png" class="logo" alt="cityride" width="60px" style="border-radius: 25px;" />
                <span class="site-name ml-2">City Ride</span> <!-- Site name added -->
            </a>
            <!-- Toggler/collapsible Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-nav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse justify-content-between" id="menu-nav">
            <!-- Left-aligned nav (default) -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white text-uppercase" href="index.php">SEARCH</a>
                </li>
                <li class="nav-item">
                    <?php
                    // Check if user is logged in
                    session_start(); // Start the session
                    if (isset($_SESSION['user_id'])) {
                        // User is logged in, show "Post Rides" option if verified
                        require_once 'db_connection.php';
                        $user_id = $_SESSION['user_id'];
                        $query = "SELECT verificationDetails FROM users WHERE userID = $user_id";
                        $result = mysqli_query($conn, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $verificationDetails = $row['verificationDetails'];
                            if ($verificationDetails == "verified") {
                                ?>
                                <a class="nav-link text-white text-uppercase" href="posthtml.php">POST RIDES</a>
                                <?php
                            } else {
                                ?>
                                <a class="nav-link text-white text-uppercase" href="viewprofile.php" onclick="showVerificationAlert()">POST RIDES</a>
                                <?php
                            }
                        } else {
                            // Handle database error or no verification details found
                            ?>
                            <a class="nav-link text-white text-uppercase" href="viewprofile.php" onclick="showVerificationAlert()">POST RIDES</a>
                            <?php
                        }
                    } else {
                        // User is not logged in, redirect to login page
                        ?>
                        <a class="nav-link text-white text-uppercase" href="../Login/index.html" onclick="showLoginPrompt()">POST RIDES</a>
                        <?php
                    }
                    ?>
                </li>
            </ul>

                <!-- Right-aligned nav -->
                <ul class="navbar-nav">
                    <?php
                    // Check if user is logged in
                     // Start the session
                    if (isset($_SESSION['user_id'])) {
                        // User is logged in, hide Sign In/Sign Up and show Logout
                        ?>  
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" data-toggle="dropdown">
                                Actions
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="showpost.php">Edit/Delete Post</a>
                                <a class="dropdown-item" href="passenger.php">Our Passenger Details</a>
                                <a class="dropdown-item" href="booked.php">Booked ride</a>
                            </div>
                        </li>
                        <?php
// Include database connection
require_once 'db_connection.php';

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // User is logged in, fetch user's name from the database
    // Assuming you have a database connection, replace 'your_database_connection' with your actual database connection variable
    $user_id = $_SESSION['user_id'];
    $query = "SELECT username FROM users WHERE userID = $user_id";
    
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        
    } else {
        // Handle database error
        $username = "Guest";
    }
} else {
    // User is not logged in, set a default value
    $username = "Guest";
}

// Fetch user details from database
$sql = "SELECT * FROM users WHERE userID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);
?>


                        <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-white" href="#" data-toggle="dropdown">
        <i ><?php if (!empty($user['newProfilePicture'])): ?>
                <!-- Display existing profile picture -->
                <img src="<?php echo $user['newProfilePicture']; ?>" alt="Profile Picture" height="30px" width="30px" class="uploaded-image";>
            <?php endif; ?></i> <?php echo $username; ?> <!-- Replace with fetched username -->
    </a>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="viewprofile.php">View Profile</a>
        <a class="dropdown-item" href="pass.php">UPDATE PASSWORD</a>
        <a class="dropdown-item" href="logout.php">Logout</a>
    </div>
</li>
                        <?php
                    } else {
                        // User is not logged in, show Sign In/Sign Up and hide Logout
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" data-toggle="dropdown">Sign In/Sign Up</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="../Login/index.html">Sign In</a>
                                <a class="dropdown-item" href="../Login/signup.php">Sign Up</a>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
     <!-- Adding jQuery library CDN -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Adding Bootstrap CDN - Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Adding Bootstrap CDN - Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Bootstrap Datepicker JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <!-- Adding JavaScript -->
    <script>
    function showLoginPrompt() {
        alert("Please log in to post a ride.");
    }

    function showVerificationAlert() {
        alert("Please verify your account by uploading Aadhar and driving license photos.");
    }
</script>

</body>
</html>