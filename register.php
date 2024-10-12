<?php
@include 'config.php';
$error = [];
if (isset($_POST['submit'])) {
    // Sanitize input
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $user_role = mysqli_real_escape_string($conn, $_POST['user_role']);

    // Check if the user already exists
    $select = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'User already exists!';
    } else {
        // Check if the passwords match
        if ($password != $confirm_password) {
            $error[] = 'Passwords do not match!';
        } else {
            // Hash the password using password_hash
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $insert = "INSERT INTO users (FirstName, LastName, Email, Password, UserRole)
                       VALUES ('$fname', '$lname', '$email', '$hashed_password', '$user_role')";

            if (mysqli_query($conn, $insert)) {
                header('Location: login.php');
                exit();
            } else {
                $error[] = 'Registration failed!';
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="form-container">
      <form action="" method="post">
        <h3>Register Now</h3>
        <?php
          if(isset($error)){
            foreach($error as $singleError){
              echo '<span class="error-msg">'.$singleError.'</span>';
            };
          };
        ?>
        <div class="name-container">
          <input
            type="text"
            name="fname"
            required
            placeholder="Enter your first name"
          />
          <input
            type="text"
            name="lname"
            required
            placeholder="Enter your last name"
          />
        </div>
        <input
          type="email"
          name="email"
          required
          placeholder="Enter your email"
        />
        <input
          type="password"
          name="password"
          required
          placeholder="Enter your password"
        />
        <input
          type="password"
          name="confirm_password"
          required
          placeholder="Confirm your password"
        />
        <select name="user_role">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
        <input
          type="submit"
          name="submit"
          value="Register Now"
          class="register-btn"
        />
        <p>Already have an account? <a href="login.php">Login now</a></p>
      </form>
    </div>
  </body>
</html>
