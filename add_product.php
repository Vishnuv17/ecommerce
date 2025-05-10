<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];

    // Use prepared statement for safety
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock_quantity, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("ssdi", $name, $description, $price, $stock_quantity);

    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully'); window.location.href='admin.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
