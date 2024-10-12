<?php
// config.php
$conn = mysqli_connect('localhost', 'root', '', 'comfortcafe',3307); 
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>