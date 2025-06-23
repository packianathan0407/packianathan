<?php
// Simulated database with images added
$products = [
    ["id" => 1, "name" => "Vanilla Cone", "price" => 50, "category" => "cone", "ingredients" => "Vanilla Ice Cream, Cone", "image" => "images/vanilla_cone.jpg"],
    ["id" => 2, "name" => "Chocolate Cone", "price" => 60, "category" => "cone", "ingredients" => "Chocolate Ice Cream, Cone", "image" => "images/chocolate_cone.jpg"],
    ["id" => 3, "name" => "Family Pack - Vanilla", "price" => 200, "category" => "family", "ingredients" => "Vanilla Ice Cream, Family Pack", "image" => "images/family_pack_vanilla.jpg"],
    ["id" => 4, "name" => "Chocobar", "price" => 70, "category" => "chocobar", "ingredients" => "Chocolate Ice Cream, Chocolate Coating", "image" => "images/chocobar.jpg"],
    ["id" => 5, "name" => "Strawberry Family Pack", "price" => 220, "category" => "family", "ingredients" => "Strawberry Ice Cream, Family Pack", "image" => "images/family_pack_strawberry.jpg"],
    ["id" => 6, "name" => "Mint Chocobar", "price" => 80, "category" => "chocobar", "ingredients" => "Mint Ice Cream, Chocolate Coating", "image" => "images/mint_chocobar.jpg"]
];

// Fetch all products or filtered by category
function getProducts($category = null, $search = null) {
    global $products;

    if ($category) {
        $products = array_filter($products, fn($product) => $product['category'] == $category);
    }

    if ($search) {
        $products = array_filter($products, fn($product) => stripos($product['name'], $search) !== false);
    }

    return json_encode(array_values($products));
}

// Fetch product by ID
function getProductById($id) {
    global $products;
    $product = array_filter($products, fn($p) => $p['id'] == $id);
    return json_encode(array_values($product));
}

// Add a new product
function addProduct($name, $price, $category, $ingredients, $image) {
    global $products;
    $newProduct = [
        "id" => count($products) + 1,
        "name" => $name,
        "price" => $price,
        "category" => $category,
        "ingredients" => $ingredients,
        "image" => $image
    ];
    array_push($products, $newProduct);
    return json_encode(["message" => "Product added successfully", "product" => $newProduct]);
}

// Handle the API requests
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $category = $_GET['category'] ?? null;
    $search = $_GET['search'] ?? null;

    if (isset($_GET['id'])) {
        echo getProductById($_GET['id']);
    } else {
        echo getProducts($category, $search);
    }
}

?>
