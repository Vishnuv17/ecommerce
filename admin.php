<?php
include 'config.php';

// Add Product Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, stock_quantity, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("ssdi", $name, $description, $price, $stock_quantity);

    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully'); window.location.href='admin.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch Data
$products = mysqli_query($conn, "SELECT * FROM products");
$customers = mysqli_query($conn, "SELECT * FROM customers");

$orders = mysqli_query($conn, "
    SELECT orders.id, customers.first_name AS customer, products.name AS product, orders.order_status
    FROM orders
    JOIN customers ON orders.customer_id = customers.id
    JOIN order_products ON orders.id = order_products.order_id
    JOIN products ON order_products.product_id = products.id
");

$product_counts = mysqli_query($conn, "
    SELECT products.name, COUNT(*) as count
    FROM orders
    JOIN order_products ON orders.id = order_products.order_id
    JOIN products ON order_products.product_id = products.id
    GROUP BY products.name
");

$customer_orders = mysqli_query($conn, "
    SELECT customers.first_name, COUNT(*) as count
    FROM orders
    JOIN customers ON orders.customer_id = customers.id
    GROUP BY customers.first_name
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="admin-container">
  <h2><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h2>

  <!-- Product Management -->
  <section class="admin-section">
    <h3>Product Management</h3>
    <button class="btn" onclick="document.getElementById('addProductForm').style.display='block'"><i class="fas fa-plus-circle"></i> Add Product</button>
    <div id="addProductForm" class="product-form-container">
      <h3>Add New Product</h3>
      <form action="admin.php" method="POST" class="product-form">
        <input type="hidden" name="add_product" value="1">
        <div class="form-group">
          <label>Product Name</label>
          <input type="text" name="name" required>
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="description" required></textarea>
        </div>
        <div class="form-group">
          <label>Price ($)</label>
          <input type="number" name="price" step="0.01" required>
        </div>
        <div class="form-group">
          <label>Stock Quantity</label>
          <input type="number" name="stock_quantity" required>
        </div>
        <button type="submit" class="btn"><i class="fas fa-plus-circle"></i> Submit Product</button>
      </form>
    </div>

    <table>
      <thead>
        <tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Stock</th><th>Created</th><th>Updated</th><th>Actions</th></tr>
      </thead>
      <tbody>
      <?php while ($row = mysqli_fetch_assoc($products)): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['name'] ?></td>
          <td><?= $row['description'] ?></td>
          <td>$<?= $row['price'] ?></td>
          <td><?= $row['stock_quantity'] ?></td>
          <td><?= $row['created_at'] ?></td>
          <td><?= $row['updated_at'] ?></td>
          <td><button class="btn"><i class="fas fa-edit"></i> Edit</button> <button class="btn"><i class="fas fa-trash"></i> Delete</button></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </section>

  <!-- Order Management -->
  <section class="admin-section">
    <h3>Order Management</h3>
    <table>
      <thead><tr><th>Order ID</th><th>Customer</th><th>Product</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
      <?php while ($row = mysqli_fetch_assoc($orders)): ?>
        <tr>
          <td>#<?= $row['id'] ?></td>
          <td><?= $row['customer'] ?></td>
          <td><?= $row['product'] ?></td>
          <td><?= $row['order_status'] ?></td>
          <td><button class="btn"><i class="fas fa-trash"></i> Delete</button></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </section>

 <!-- Group by Product -->
<div class="summary-box group-summary">
  <h4><i class="fas fa-box"></i> Group by Product</h4>
  <ul>
    <?php while ($row = mysqli_fetch_assoc($product_counts)): ?>
      <li><span class="name"><?= $row['name'] ?>:</span> <span class="count"><?= $row['count'] ?> order(s)</span></li>
    <?php endwhile; ?>
  </ul>
</div>

<!-- Orders Per Customer -->
<div class="summary-box customer-summary">
  <h4><i class="fas fa-user"></i> Orders Per Customer</h4>
  <ul>
    <?php while ($row = mysqli_fetch_assoc($customer_orders)): ?>
      <li><span class="name"><?= $row['first_name'] ?>:</span> <span class="count"><?= $row['count'] ?> order(s)</span></li>
    <?php endwhile; ?>
  </ul>
</div>


  <!-- Customer Management -->
  <section class="admin-section">
    <h3>Customer Management</h3>
    <table>
      <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Created At</th></tr></thead>
      <tbody>
      <?php while ($row = mysqli_fetch_assoc($customers)): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
          <td><?= $row['email'] ?></td>
          <td><?= $row['created_at'] ?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </section>
</div>

<footer class="footer">
  <p class="footer__title">&#169; Vishnu</p>
  <div class="footer__social">
    <a href="https://vishnuofficial17.netlify.app/" class="footer__icon"><i class='bx bx-globe'></i></a>
    <a href="https://www.linkedin.com/in/vishnuv1708/" class="footer__icon"><i class='bx bxl-linkedin'></i></a>
    <a href="mailto:vishnuv1708@gmail.com" class="footer__icon"><i class='bx bxs-envelope'></i></a>
    <a href="https://github.com/Vishnuv17" class="footer__icon"><i class='bx bxl-github'></i></a>
    <a href="https://www.instagram.com/vishnuv.dev/" class="footer__icon"><i class='bx bxl-instagram-alt'></i></a>
  </div>
  <p class="footer__copy">&#169; Vishnu. All rights reserved</p>
</footer>

</body>
</html>
