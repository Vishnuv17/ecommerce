<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // The password entered by the user

    // Check if email exists in the database
    $query = "SELECT * FROM customers WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Email exists, now check the password
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password_hash'])) {
            // Password matches, login successful
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            header('Location: index.php'); // Redirect to home or dashboard
            exit;
        } else {
            // Invalid password
            echo "<script>alert('Incorrect password!'); window.location.href='login.html';</script>";
            exit;
        }
    } else {
        // Email doesn't exist
        echo "<script>alert('Email not registered!'); window.location.href='login.html';</script>";
        exit;
    }
}
?>
