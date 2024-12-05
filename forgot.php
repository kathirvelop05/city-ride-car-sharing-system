<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password</title>
</head>
<body>
  <h2>Change Password</h2>
  <form action="update_password.php" method="post">
    <div>
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>
    </div>
    <div>
      <label for="new_password">New Password:</label>
      <input type="password" id="new_password" name="new_password" required>
    </div>
    <div>
      <button type="submit">Update Password</button>
    </div>
  </form>
</body>
</html>
