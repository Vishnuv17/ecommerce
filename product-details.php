<?php
include('config.php');
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Fetch product details from DB based on the product ID passed in the URL
$product_id = isset($_GET['id']) ? $_GET['id'] : 0;
$query = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Product not found!";
    exit;
}

// Add to Cart functionality via session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    // Get product data from POST request
    $product_id = $_POST['product_id'];
    $quantity = 1;  // Default quantity is 1 for now

    // Check if product is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['id'] == $product_id) {
            $cart_item['quantity'] += 1; // Increase quantity if product is already in cart
            $found = true;
            break;
        }
    }

    // If product wasn't in the cart, add it
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity,
        ];
    }

    // Redirect to avoid form resubmission
    header("Location: product-details.php?id=" . $product_id);
    exit;
}

// Buy Now functionality - redirects to checkout page
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy_now'])) {
    $product_id = $_POST['product_id'];
    $quantity = 1;

    $found = false;
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['id'] == $product_id) {
            $cart_item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product_id,
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity,
        ];
    }

    // Redirect to checkout page
    header("Location: checkout.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Product View</title>
  <link rel="stylesheet" href="styles.css" />
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

  <div class="product-view-container">
    <div class="product-view-details">
      <h1><i class="fas fa-box-open"></i> <?php echo $product['name']; ?></h1> <!-- Product Name -->
      <p class="price">$<?php echo $product['price']; ?></p> <!-- Product Price -->
      <p class="description"><?php echo $product['description']; ?></p> <!-- Product Description -->
      
      <!-- Add to Cart Form -->
      <form method="POST" action="product-details.php?id=<?php echo $product['id']; ?>">
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>" />
        <button type="submit" name="add_to_cart" class="add-to-cart-button">
          <i class="fas fa-cart-plus"></i> Add to Cart
        </button>
      </form>

      <!-- Buy Now button -->
       <form method="POST" action="product-details.php?id=<?php echo $product['id']; ?>">
  <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>" />
  <button type="submit" name="buy_now" class="buy-button">
    <i class="fas fa-bolt"></i> Buy Now
  </button>
</form>

    </div>
  </div>

  <footer class="footer">
    <p class="footer__title">&#169; Vishnu</p>
    <div class="footer__social">
      <a href="https://vishnuofficial17.netlify.app/" class="footer__icon"><i class='bx bx-globe'></i></a>
        <a href="https://www.linkedin.com/in/vishnuv1708/" class="footer__icon"><i class='bx bxl-linkedin'></i></a>
        <a href="mailto:vishnuv1708@gmail.com" class="footer__icon"><i class='bx bxs-envelope'></i></a>
        <a href="https://github.com/Vishnuv17" class="footer__icon"><i class='bx bxl-github'></i></a>
        <a href="https://www.instagram.com/vishnuv.dev/" class="footer__icon"><i class='bx bxl-instagram-alt' ></i></a>
    </div>
    <p class="footer__copy">&#169; Vishnu. All rights reserved</p>
  </footer>
</body>
</html>
