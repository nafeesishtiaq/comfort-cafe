let cart = [];
let totalPrice = 0;

// Function to add item to cart
function addToCart(itemName, itemPrice) {
  // Check if item is already in the cart
  const existingItem = cart.find((item) => item.name === itemName);

  if (existingItem) {
    // If item exists, increase its quantity
    existingItem.quantity += 1;
  } else {
    // If item doesn't exist, add it with quantity 1
    cart.push({ name: itemName, price: itemPrice, quantity: 1 });
  }

  // Update total price
  totalPrice += parseFloat(itemPrice);
  // Update cart display
  updateCartDisplay();
}

// Function to remove item from cart one by one
function removeFromCart(index) {
  const itemToRemove = cart[index];

  if (itemToRemove.quantity > 1) {
    // Decrease quantity by 1
    itemToRemove.quantity -= 1;
    // Subtract only one instance of the item's price
    totalPrice -= parseFloat(itemToRemove.price);
  } else {
    // If quantity is 1, remove the item completely
    totalPrice -= parseFloat(itemToRemove.price);
    cart.splice(index, 1);
  }

  // Update the cart display
  updateCartDisplay();
}

// Function to update the cart display
function updateCartDisplay() {
  const cartItemsContainer = document.getElementById("cart-items");
  const totalPriceContainer = document.getElementById("total-price");

  // Clear the current cart display
  cartItemsContainer.innerHTML = "";

  // Add each item in the cart to the display
  cart.forEach((item, index) => {
    const li = document.createElement("li");
    li.textContent = `${item.name} X ${item.quantity} - $${(
      item.price * item.quantity
    ).toFixed(2)}`;

    // Create a remove button
    const removeButton = document.createElement("button");
    removeButton.textContent = "Remove";
    removeButton.style.marginLeft = "10px";
    removeButton.addEventListener("click", () => removeFromCart(index));

    // Append the remove button to the list item
    li.appendChild(removeButton);
    cartItemsContainer.appendChild(li);
  });

  // Update the total price
  totalPriceContainer.textContent = `Total: $${totalPrice.toFixed(2)}`;
}

// Add event listeners for the "Add to Cart" buttons
document.querySelectorAll(".menu-item button").forEach((button) => {
  button.addEventListener("click", (e) => {
    const itemElement = e.target.parentElement;
    const itemName = itemElement.querySelector("h4").textContent;
    const itemPrice = itemElement
      .querySelector("p:nth-child(3)")
      .textContent.split("$")[1];
    addToCart(itemName, itemPrice);
  });
});
