<?php
@include 'config.php';

session_start();
$error = [];

if (isset($_POST['submit'])) {
    // Sanitize input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the user exists
    $select = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        // Verify the password
        if (password_verify($password, $row['Password'])) {
            if ($row['UserRole'] == 'admin') {
                $_SESSION['admin_name'] = $row['FirstName'];
                header('Location: admin.php');
                exit();
            } else if ($row['UserRole'] == 'user') {
                $_SESSION['user_name'] = $row['FirstName'];
                header('Location: user.php');
                exit();
            }
        } else {
            $error[] = 'Incorrect email or password';
        }
    } else {
        $error[] = 'No user found with this email';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="form-container">
      <form action="" method="post">
        <h3>Login now</h3>
        <?php
          if (isset($error)) {
            foreach ($error as $singleError) {
              echo '<span class="error-msg">'.$singleError.'</span>';
            }
          }
        ?>
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
          type="submit"
          name="submit"
          value="Login now"
          class="register-btn"
        />
        <p>Don't have an account? <a href="register.php">Register now</a></p>
      </form>
    </div>
  </body>
</html>
