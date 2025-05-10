<?php include('config.php'); 
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
$user_name = $_SESSION['first_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home</title>
  <link rel="stylesheet" href="styles.css">
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
        <li><a href="#products"><i class="fas fa-box-open"></i> Products</a></li>
        <li><a href="checkout.php"><i class="fas fa-shopping-cart"></i> Cart</a></li>
        <li><a href="account.php"><i class="fas fa-user-circle"></i> Account</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-in-alt"></i> Logout</a></li>
      </ul>
    </nav>
  </div>
</header>

<section class="hero">
  <div class="hero-content">
    <h2>
  <span style="color: #5C6BC0; font-weight: bolder; text-shadow: 3px 3px 5px rgb(255, 255, 255);">Hii <?php echo $user_name; ?></span>, Welcome to My E-Commerce
</h2>

    <p>Browse the best products online and enjoy hassle-free shopping experience.</p>
    <a href="#products" class="btn"><i class="fas fa-box-open"></i> Browse Products</a>
  </div>
</section>
<!-- Featured Products Section -->
<section class="products" id="products">
  <h2>Featured Products</h2>
  <div class="product-grid">
    <?php
    $result = mysqli_query($conn, "SELECT * FROM products");
    while($row = mysqli_fetch_assoc($result)) {
      echo "
      <div class='product'>
        <h3>{$row['name']}</h3>
        <div class='product-info'>
          <p>Price: \${$row['price']}</p>
          <p>Stock: {$row['stock_quantity']}</p>
        </div>
        <a href='product-details.php?id={$row['id']}' class='btn'><i class='fas fa-eye'></i> View Details</a>
      </div>";
    }
    ?>
  </div>
</section>

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
