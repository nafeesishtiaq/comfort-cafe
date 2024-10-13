<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('Location: login.php');  // Redirect to login if not an admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin</title>
  </head>
  <body>
    <h1>This is admin panel</h1>
  </body>
</html>
