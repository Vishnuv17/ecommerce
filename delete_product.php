<?php
// Include database connection
include('config.php');

// Get the product ID from the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Delete the product from the database
    $query = "DELETE FROM products WHERE id = $productId";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Product deleted successfully'); window.location.href = 'admin.php';</script>";
    } else {
        echo "<script>alert('Error deleting product'); window.location.href = 'admin.php';</script>";
    }
} else {
    echo "<script>alert('Product ID is missing'); window.location.href = 'admin.php';</script>";
}
?>
