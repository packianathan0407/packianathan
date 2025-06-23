<?php
// Include database configuration
include 'db_config.php';

// Get the raw POST data (order details)
$orderData = json_decode(file_get_contents('php://input'), true);

// Check if the data is received properly
if (!empty($orderData)) {
    // Get order details
    $items = $orderData['items']; 
    $total = $orderData['totalPrice']; // Make sure you're using the correct total key here

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check for database connection error
    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]);
        exit();
    }

    // Insert the order into the 'orders' table
    $sql = "INSERT INTO orders (total_price) VALUES ('$total')";
    if ($conn->query($sql) === TRUE) {
        // Get the inserted order ID
        $orderId = $conn->insert_id; // This is the correct order ID for the current order

        // Insert each item in the order details table using the correct order ID
        foreach ($items as $item) {
            $itemName = $item['name'];
            $itemPrice = $item['price'];

            // Ensure order_id is set to the generated $orderId
            $sqlItem = "INSERT INTO order_items1 (order_id, item_name, item_price) VALUES ('$orderId', '$itemName', '$itemPrice')";
            if (!$conn->query($sqlItem)) {
                // Error inserting order item
                echo json_encode(['status' => 'error', 'message' => 'Failed to insert order item: ' . $conn->error]);
                exit();
            }
        }

        // Close connection
        $conn->close();

        // Send a success response
        echo json_encode(['status' => 'success', 'message' => 'Order placed successfully']);
    } else {
        // If insertion failed
        echo json_encode(['status' => 'error', 'message' => 'Failed to place the order: ' . $conn->error]);
    }
} else {
    // Invalid data sent
    echo json_encode(['status' => 'error', 'message' => 'Invalid order data']);
}
?>
