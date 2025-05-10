<?php
session_start();
include('config.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$user_query = "SELECT * FROM customers WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Fetch order history (assumes `customer_id` in `orders` table)
$order_query = "SELECT * FROM orders WHERE customer_id = $user_id ORDER BY created_at DESC";
$order_result = mysqli_query($conn, $order_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Account</title>
  <link href="styles.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <header>
  <div class="navbar">
    <h1><i class="fas fa-store"></i> My E-Commerce</h1>
    <nav>
      <ul>
        <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="index.php#products"><i class="fas fa-box-open"></i> Products</a></li>
        <li><a href="checkout.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
        <li><a href="account.php"><i class="fas fa-user-circle"></i> Account</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-in-alt"></i> Logout</a></li>
      </ul>
    </nav>
  </div>
</header>

  <div class="account-container">
    <div class="account-header">
      <h2><i class="fas fa-user-circle"></i> My Account</h2>
    </div>

    <div class="profile-info">
      <div class="info">
        <p><i class="fas fa-user"></i> <strong>Name:</strong> <?php echo $user['first_name'] . ' ' . $user['last_name']; ?></p>
        <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <?php echo $user['email']; ?></p>
      </div>
    </div>

    <div class="order-history">
      <h3><i class="fas fa-clipboard-list"></i> Order History</h3>
      <input type="text" placeholder="Search...">
      <?php
      if (mysqli_num_rows($order_result) > 0) {
          while ($order = mysqli_fetch_assoc($order_result)) {
              echo '<div class="order">';
              echo '<p><strong>Order ID:</strong> #' . $order['id'] . '</p>';
              echo '<p><strong>Status:</strong> ' . $order['order_status'] . '</p>';
              echo '<p><strong>Total:</strong> $' . $order['total_price'] . '</p>';
              echo '<p><strong>Date:</strong> ' . $order['created_at'] . '</p>';
              echo '</div>';
          }
      } else {
          echo '<p>No orders found.</p>';
      }
      ?>
    </div>

    <form method="POST" action="logout.php">
      <button type="submit" class="logout">Logout</button>
    </form>
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
