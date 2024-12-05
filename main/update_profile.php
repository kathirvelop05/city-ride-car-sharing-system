<?php
// Include database connection
include 'db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user ID from session
    $user_id = $_POST['userID'];

    // Retrieve form data
    $username = $_POST['username'];
    $fullName = $_POST['fullName'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $district = $_POST['district'];

    // Initialize variables to store uploaded file paths
    $aadharCardImage = '';
    $drivingLicenseImage = '';
    $newProfilePicture = '';

    // Handle file uploads for Aadhar Card Image, Driving License Image, and Profile Picture
    if (!empty($_FILES['aadharCardImage']['name'])) {
        $aadharCardImage = uploadFile($_FILES['aadharCardImage']);
    }
    if (!empty($_FILES['drivingLicenseImage']['name'])) {
        $drivingLicenseImage = uploadFile($_FILES['drivingLicenseImage']);
    }
    if (!empty($_FILES['newProfilePicture']['name'])) {
        $newProfilePicture = uploadFile($_FILES['newProfilePicture']);
    }

    // Get existing image paths from the database
    $sql = "SELECT aadharCardImage, drivingLicenseImage, newProfilePicture FROM users WHERE userID=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $existingAadharCardImage, $existingDrivingLicenseImage, $existingNewProfilePicture);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Use existing images if new ones are not provided
    $aadharCardImage = ($aadharCardImage != '') ? $aadharCardImage : $existingAadharCardImage;
    $drivingLicenseImage = ($drivingLicenseImage != '') ? $drivingLicenseImage : $existingDrivingLicenseImage;
    $newProfilePicture = ($newProfilePicture != '') ? $newProfilePicture : $existingNewProfilePicture;

    // Update user profile in the database
    $sql = "UPDATE users SET username=?, fullName=?, dateOfBirth=?, gender=?, email=?, phoneNumber=?, district=?, aadharCardImage=?, drivingLicenseImage=?, newProfilePicture=? WHERE userID=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssssi", $username, $fullName, $dateOfBirth, $gender, $email, $phoneNumber, $district, $aadharCardImage, $drivingLicenseImage, $newProfilePicture, $user_id);
    mysqli_stmt_execute($stmt);

    // Redirect to view profile page after update
    header("Location: viewprofile.php");
    exit();
}

// Function to handle file upload
function uploadFile($file) {
    $target_dir = "uploads/"; // Directory where files will be stored
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file was uploaded
    if (empty($file["tmp_name"])) {
        return ''; // Return empty string if no file uploaded
    }

    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($file["size"] > 5000000) { // Adjust maximum file size as needed
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG, JPEG, PNG files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    return ''; // Return empty string if upload fails
}
?>
