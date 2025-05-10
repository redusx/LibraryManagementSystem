<?php
require_once 'header.php';
?>

<div class="hero-section">
    <h1>Welcome to the Library Management System</h1>
    <p class="hero-subtitle">Your digital gateway to knowledge and discovery</p>
</div>

<?php if (isLoggedIn()): ?>
    <div class="welcome-card">
        <div class="welcome-header">
            <i class="fas fa-user-circle"></i>
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <i class="fas fa-plus-circle"></i>
                <h3>Add Books</h3>
                <p>Contribute to our collection by adding new books</p>
                <a href="add_book.php" class="feature-link">
                    <span class="link-with-icon">Add New Book <i class="fas fa-arrow-right"></i></span>
                </a>
            </div>
            <div class="feature-card">
                <i class="fas fa-search"></i>
                <h3>Search Library</h3>
                <p>Find books by title, author, or ISBN</p>
                <a href="search.php" class="feature-link">
                    <span class="link-with-icon">Start Searching <i class="fas fa-arrow-right"></i></span>
                </a>
            </div>
            <div class="feature-card">
                <i class="fas fa-bookmark"></i>
                <h3>Reserve Books</h3>
                <p>Reserve available books for your reading</p>
                <a href="search.php" class="feature-link">
                    <span class="link-with-icon">Browse Books <i class="fas fa-arrow-right"></i></span>
                </a>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="welcome-card">
        <div class="welcome-header">
            <i class="fas fa-book-reader"></i>
            <h2>Get Started</h2>
        </div>
        <p class="welcome-text">Join our library community to access our collection of books and manage your reading journey.</p>
        <div class="auth-buttons">
            <a href="login.php" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Login</a>
            <a href="register.php" class="btn btn-secondary"><i class="fas fa-user-plus"></i> Register</a>
        </div>
    </div>
<?php endif; ?>

<?php require_once 'footer.php'; ?> 