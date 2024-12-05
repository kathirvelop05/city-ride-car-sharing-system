<?php
// Include database connection
include 'db_connection.php';
include '../includes/header.php';

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user details from database
$sql = "SELECT * FROM users WHERE userID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link rel="stylesheet" type="text/css" href="css/viewprofile.css" />
    <!-- Font Awesome CSS for pencil icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        main {
            align-items:center;
            position:absolute;
            width:1000px;
            margin: 20px auto;
            margin-left:10%;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-top: 0;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="email"],
        input[type="tel"],
        input[type="file"],
        textarea {
            width: calc(100% - 24px); /* Adjust based on button width and margin */
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="text"]:read-only,
        input[type="date"]:read-only,
        input[type="email"]:read-only,
        input[type="tel"]:read-only,
        textarea:read-only {
            background-color: #f2f2f2;
        }

        .edit-icon {
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .edit-icon i {
            color: #007bff;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
<body>
<main>
    <h1>YOUR PROFILE</h1>
    <?php if ($user): ?>
        <form method="POST" action="update_profile.php" enctype="multipart/form-data">

        <label for="newProfilePicture">Profile Picture:</label><br>
            <?php if (!empty($user['newProfilePicture'])): ?>
                <!-- Display existing profile picture -->
                <img src="<?php echo $user['newProfilePicture']; ?>" alt="Profile Picture" height="100px" width="100px"><br>
            <?php endif; ?>
            <input type="file" id="newProfilePicture" name="newProfilePicture" accept="image/*"><br><br>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="editable-field" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
            <button type="button" class="edit-icon" onclick="toggleEditMode('username')"><i class="fas fa-pencil-alt"></i></button><br><br>

            <!-- Add other fields similarly -->
            <!-- Modify the button to include pencil icon -->
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" class="editable-field" value="<?php echo htmlspecialchars($user['fullName']); ?>" readonly>
            <button type="button" class="edit-icon" onclick="toggleEditMode('fullName')"><i class="fas fa-pencil-alt"></i></button><br><br>

            <label for="dateOfBirth">Date of Birth:</label>
            <input type="date" id="dateOfBirth" name="dateOfBirth" class="editable-field" value="<?php echo htmlspecialchars($user['dateOfBirth']); ?>" readonly>
            <button type="button" class="edit-icon" onclick="toggleEditMode('dateOfBirth')"><i class="fas fa-pencil-alt"></i></button><br><br>

            <!-- Add Aadhar Card Image upload field -->

            <!-- Show Aadhar Card Image -->
            <label for="aadharCardImage">Aadhar Card Image:</label><br>
            <?php if (!empty($user['aadharCardImage'])): ?>
                <img src="<?php echo $user['aadharCardImage']; ?>" alt="Aadhar Card Image" style="max-width: 200px;"><br><br>
            <?php endif; ?>
            <input type="file" id="aadharCardImage" name="aadharCardImage" accept="image/*"><br><br>

            <!-- Show Driving License Image -->

            <!-- Modify the button to include pencil icon -->
            <label for="drivingLicenseImage">Driving License Image:</label><br>
            <?php if (!empty($user['drivingLicenseImage'])): ?>
                <img src="<?php echo $user['drivingLicenseImage']; ?>" alt="Driving License Image" style="max-width: 200px;"><br><br>
            <?php endif; ?>
            <input type="file" id="drivingLicenseImage" name="drivingLicenseImage" accept="image/*"><br><br>

            <label for="verificationDetails">Verification Details:</label>
            <textarea id="verificationDetails" name="verificationDetails" class="editable-field" readonly><?php echo htmlspecialchars($user['verificationDetails']); ?></textarea><br><br>

            <label for="gender">Gender:</label>
            <input type="text" id="gender" name="gender" class="editable-field" value="<?php echo htmlspecialchars($user['gender']); ?>" readonly>
            <button type="button" class="edit-icon" onclick="toggleEditMode('gender')"><i class="fas fa-pencil-alt"></i></button><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="editable-field" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
            <button type="button" class="edit-icon" onclick="toggleEditMode('email')"><i class="fas fa-pencil-alt"></i></button><br><br>

            <label for="phoneNumber">Phone Number:</label>
            <input type="tel" id="phoneNumber" name="phoneNumber" class="editable-field" value="<?php echo htmlspecialchars($user['phoneNumber']); ?>" readonly>
            <button type="button" class="edit-icon" onclick="toggleEditMode('phoneNumber')"><i class="fas fa-pencil-alt"></i></button><br><br>

            <label for="district">District:</label>
            <input type="text" id="district" name="district" class="editable-field" value="<?php echo htmlspecialchars($user['district']); ?>" readonly>
            <button type="button" class="edit-icon" onclick="toggleEditMode('district')"><i class="fas fa-pencil-alt"></i></button><br><br>

            
            <!-- Add hidden input fields for user ID and any other necessary fields -->
            <input type="hidden" name="userID" value="<?php echo $user_id; ?>">

            <input type="submit" value="Save">
        </form>
    <?php else: ?>
        <p>User details not found.</p>
    <?php endif; ?>

    <!-- JavaScript to toggle edit mode -->
    <script>
        function toggleEditMode(fieldName) {
            var field = document.getElementById(fieldName);
            if (field.readOnly) {
                field.readOnly = false;
                field.classList.add('editable-field');
            } else {
                field.readOnly = true;
                field.classList.remove('editable-field');
            }
        }
    </script>
</main>
</body>
</html>
