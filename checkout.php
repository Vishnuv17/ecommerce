<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$cart = $_SESSION['cart'];
$total_price = 0;

// REMOVE ITEM
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item'])) {
    $remove_id = $_POST['remove_id'];
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['id'] == $remove_id) {
            unset($_SESSION['cart'][$index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // reindex
            break;
        }
    }
    header("Location: checkout.php");
    exit;
}

// UPDATE QUANTITIES
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        $quantity = max(1, intval($quantity)); // Ensure quantity is at least 1
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product_id) {
                $item['quantity'] = $quantity;
                break;
            }
        }
    }
    header("Location: checkout.php"); // Redirect after update
    exit;
}

// CONFIRM ORDER
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
    if (empty($cart)) {
        echo "<script>alert('Cart is empty!'); window.location.href='checkout.php';</script>";
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $order_status = 'Pending';
    $created_at = date('Y-m-d H:i:s');

    mysqli_query($conn, "INSERT INTO orders (customer_id, order_status, total_price, created_at, updated_at)
                         VALUES ('$user_id', '$order_status', '0', '$created_at', '$created_at')");
    $order_id = mysqli_insert_id($conn);

    $final_total = 0;
    foreach ($cart as $item) {
        $product_id = $item['id'];
        $quantity = $item['quantity'];
        $result = mysqli_query($conn, "SELECT price FROM products WHERE id = $product_id");
        $product = mysqli_fetch_assoc($result);
        $unit_price = $product['price'];
        $subtotal = $unit_price * $quantity;
        $final_total += $subtotal;

        mysqli_query($conn, "INSERT INTO order_products (order_id, product_id, quantity, unit_price)
                             VALUES ('$order_id', '$product_id', '$quantity', '$unit_price')");
    }

    mysqli_query($conn, "UPDATE orders SET total_price = $final_total WHERE id = $order_id");

    $_SESSION['cart'] = [];
    echo "<script>window.location.href='thankyou.html';</script>";
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Checkout</title>
  <link rel="stylesheet" href="styles.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
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

<section class="checkout">
  <h2><i class="fas fa-shopping-cart"></i> Checkout</h2>
  <div class="checkout-container">
    <div class="cart-items">
      <?php if (empty($cart)) : ?>
        <p>Your cart is empty!</p>
      <?php else: ?>
        <form method="POST" action="checkout.php">
          <?php 
          $total_price = 0; // Recalculate total price after updating the cart
          foreach ($cart as $item) :
            $product_id = $item['id'];
            $quantity = $item['quantity'];
            $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
            $product = mysqli_fetch_assoc($result);
            $total_item_price = $product['price'] * $quantity;
            $total_price += $total_item_price;
          ?>
          <div class="cart-item">
            <div class="product-dtl">
              <h3><i class="fas fa-box-open"></i> Product Name: <?php echo $product['name']; ?></h3>
              <p><i class="fas fa-dollar-sign"></i> Price: $<?php echo $product['price']; ?></p>
              <div class="product-qty">
                <label for="quantity-<?php echo $product['id']; ?>">Quantity:</label>
                <input type="number" id="quantity-<?php echo $product['id']; ?>" name="quantity[<?php echo $product['id']; ?>]" value="<?php echo $quantity; ?>" min="1" style="width: 60px; padding: 5px; margin-top: 5px;">
              </div>
              <p><i class="fas fa-tags"></i> Total: $<?php echo $total_item_price; ?></p>
            </div>
            <div class="product-remove-btn">
              <form method="POST" action="checkout.php" onsubmit="return confirm('Are you sure you want to remove this item?');">
                <input type="hidden" name="remove_id" value="<?php echo $product['id']; ?>">
                <button type="submit" class="btn" name="remove_item"><i class="fas fa-trash-alt"></i> Remove</button>
              </form>
            </div>
          </div>
          <?php endforeach; ?>
          <div class="checkout-button">
            <button type="submit" class="btn" name="update_cart"><i class="fas fa-check-circle"></i> Update Cart</button>
          </div>
        </form>
      <?php endif; ?>
    </div>

    <div class="checkout-payment">
      <div class="total-price">
        <h3>Total Price: $<?php echo $total_price; ?></h3>
      </div>

      <div class="payment-info">
        <h3>Payment Method</h3>
        <p>Cash on Delivery</p>
      </div>

      <div class="checkout-button">
        <form method="POST" action="checkout.php">
          <button type="submit" name="confirm_order" class="btn">
            <i class="fas fa-check-circle"></i> Confirm
          </button>
        </form>
      </div>
    </div>
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
