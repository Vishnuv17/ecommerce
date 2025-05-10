<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);

    // Check if email already exists
    $check_query = "SELECT * FROM customers WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Email already registered — show alert
        echo "<script>alert('Email already registered!'); window.location.href='register.html';</script>";
        exit;
    }

    // Insert new user
    $query = "INSERT INTO customers (email, password_hash, first_name, last_name, created_at, updated_at)
              VALUES ('$email', '$password', '$first_name', '$last_name', NOW(), NOW())";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registered successfully!'); window.location.href='login.html';</script>";
        exit;
    } else {
        echo "<script>alert('Registration failed!'); window.location.href='register.html';</script>";
        exit;
    }
}
?>
