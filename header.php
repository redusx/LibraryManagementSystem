<?php
session_start();
require_once 'config.php';

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div class="nav-container">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <?php if (isLoggedIn()): ?>
                <a href="add_book.php"><i class="fas fa-plus"></i> Add Book</a>
                <a href="search.php"><i class="fas fa-search"></i> Search Books</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            <?php else: ?>
                <a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="register.php"><i class="fas fa-user-plus"></i> Register</a>
            <?php endif; ?>
        </div>
    </nav>
    <div class="container"> 