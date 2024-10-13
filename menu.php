<?php
@include 'config.php';
session_start();

if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <p>Comfort Cafe</p>
    <nav>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="reservation.php">Reservation</a></li>
            <li><a href="reviews.php">Reviews</a></li>
            <li><a href="aboutus.php">About Us</a></li>
        </ul>
    </nav>
    <div class="dropdown">
        <button class="dropbtn">User</button>
        <div class="dropdown-content">
            <a href="#">Profile</a>
            <a href="#">Admin</a>
            <a href="logout.php">Sign Out</a>
        </div>
    </div>
</header>

<div class="menu-container">
    <h2>Our Menu</h2>

    <?php
    // Fetch distinct categories
    $categoriesQuery = "SELECT DISTINCT Category FROM MENU";
    $categoriesResult = mysqli_query($conn, $categoriesQuery);

    if (mysqli_num_rows($categoriesResult) > 0) {
        while ($categoryRow = mysqli_fetch_assoc($categoriesResult)) {
            $category = $categoryRow['Category'];

            echo "<div class='category-section'>";
            echo "<h3 class='category-title'>$category</h3>";

            // Fetch menu items for the current category
            $itemsQuery = "SELECT ItemName, Ingredients, Price, ImagePath FROM MENU WHERE Category='$category'";
            $itemsResult = mysqli_query($conn, $itemsQuery);

            if (mysqli_num_rows($itemsResult) > 0) {
                echo "<div class='items-row'>";
                while ($itemRow = mysqli_fetch_assoc($itemsResult)) {
                    echo "<div class='menu-item'>";
                    echo "<img src='" . $itemRow['ImagePath'] . "' alt='" . $itemRow['ItemName'] . "' class='food-img'>";
                    echo "<h4>" . $itemRow['ItemName'] . "</h4>";
                    echo "<p>Ingredients: " . $itemRow['Ingredients'] . "</p>";
                    echo "<p>Price: $" . $itemRow['Price'] . "</p>";
                    echo "<button>Add to cart</button>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>No items found in this category.</p>";
            }
            echo "</div>";
        }
    } else {
        echo "<p>No categories found.</p>";
    }
    ?>
</div>

<div class="cart-container">
    <h2>Your Cart</h2>
    <ul id="cart-items"></ul>
    <p id="total-price">Total: $0.00</p>
    <button id="checkout-button">Checkout</button>
</div>

<script src="script.js"></script>
</body>
</html>
