// Initialize an empty cart array
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Function to add item to cart
function addToCart(product) {
    alert('Item added to cart!');
    cart.push(product); // Add the product to the cart array
    localStorage.setItem('cart', JSON.stringify(cart)); // Save cart to localStorage
    updateCartDisplay(); // Update cart display
    
}



// Function to update cart display
function updateCartDisplay() {
    const cartList = document.getElementById('cart-list');
    cartList.innerHTML = ''; // Clear the current cart items
    let totalPrice = 0;

    // Display all items in the cart
    cart.forEach(item => {
        const li = document.createElement('li');
        li.textContent = `${item.name} - ₹${item.price}`;
        cartList.appendChild(li);
        totalPrice += item.price;
    });

    // Update total price
    document.getElementById('total-price').textContent = totalPrice;
}

// Function to place the order
function order() {
    if (cart.length === 0) {
        alert('Your cart is empty. Please add items before ordering.');
        return;
    }

    // Create an object to store the order details
    const orderDetails = {
        items: cart,
        totalPrice: cart.reduce((sum, item) => sum + item.price, 0)
    };

    // Send the order details to the server (order.php)
    fetch('order.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(orderDetails)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);  // Log the response for debugging
        if (data.status === 'success') {
            alert('Order placed successfully!');
            localStorage.removeItem('cart'); // Clear the cart after successful order
            cart = [];
            updateCartDisplay(); // Update the cart display
        } else {
            alert('Failed to place order. Please try again: ' + data.message);
        }
    })
    .catch(error => {
        console.error(error);  // Log error details
        alert('An error occurred. Please try again later.');
    });
}

// Function to clear the cart
function clearCart() {
    // Remove the cart from localStorage
    localStorage.removeItem('cart');

    // Clear the cart array in memory
    cart = [];

    // Update the cart display
    updateCartDisplay();

    // Optionally, show a confirmation message
    alert('Your cart has been cleared!');
}


// Function to filter products based on search input


function filterProducts() {
    const searchInput = document.getElementById("search-input").value;
    const products = document.querySelectorAll(".product");

    products.forEach((product) => {
        const productName = product.dataset.name;
        if (productName.includes(searchInput)) {
            product.style.display = "block"; // Show the product
        } else {
            product.style.display = "none"; // Hide the product
        }
    });
}


// Initialize the cart display when the page loads
updateCartDisplay();
