<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/main1.css">
    <title>Signup Page</title>
</head>
<style>
    form
    {
        top:10px;
        position:absolute;
    }
</style>
<body>
    <form id="signupForm" action="back.php" method="POST" onsubmit="return validateForm()">
        <h2>Sign Up</h2>
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" required>
        
        <label for="dateOfBirth">Date of Birth:</label>
        <input type="date" id="dateOfBirth" name="dateOfBirth" required>
        
        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <span id="emailError" class="error"></span>
        
        <label for="phoneNumber">Phone Number:</label>
        <input type="text" id="phoneNumber" name="phoneNumber" required>
        <span id="phoneError" class="error"></span>
        
        <label for="district">District:</label>
        <input type="text" id="district" name="district" required>
        
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <input type="submit" value="Sign Up">
        <p>Already have an account? <a href="index.html">Sign in</a></p>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
    function validateForm() {
        var fullName = document.getElementById('fullName').value.trim();
        var dateOfBirth = document.getElementById('dateOfBirth').value.trim();
        var gender = document.getElementById('gender').value;
        var email = document.getElementById('email').value.trim();
        var phoneNumber = document.getElementById('phoneNumber').value.trim();
        var district = document.getElementById('district').value.trim();
        var username = document.getElementById('username').value.trim();
        var password = document.getElementById('password').value.trim();
        
        var emailError = document.getElementById('emailError');
        if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
            emailError.textContent = 'Invalid email address';
            return false;
        } else {
            emailError.textContent = '';
        }
        
        var phoneError = document.getElementById('phoneError');
        if (!/^\d{10}$/.test(phoneNumber)) {
            phoneError.textContent = 'Invalid phone number';
            return false;
        } else {
            phoneError.textContent = '';
        }

        Swal.fire({
            title: 'Success!',
            text: 'You have successfully signed up.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make an AJAX request to back.php to submit the form data
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "back.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Optionally, you can handle the response from back.php here
                        // For example, display a message or handle any errors
                    }
                };
                xhr.send("fullName=" + fullName + "&dateOfBirth=" + dateOfBirth + "&gender=" + gender + "&email=" + email + "&phoneNumber=" + phoneNumber + "&district=" + district + "&username=" + username + "&password=" + password);
            }
        });

        // Prevent the form from submitting automatically
        return false;
    }
</script>

</body>
</html>
