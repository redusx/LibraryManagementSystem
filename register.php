<?php
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = trim($_POST['email']);
    
    $errors = [];
    
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute([$username, $hashedPassword, $email]);
            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $errors[] = "Username or email already exists";
            } else {
                $errors[] = "Registration failed";
            }
        }
    }
}
?>

<div class="form-container">
    <h2><i class="fas fa-user-plus"></i> Register</h2>

    <?php if (!empty($errors)): ?>
        <div class="errors">
            <?php foreach ($errors as $error): ?>
                <p class="error"><i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="" class="form">
        <div class="form-group">
            <label for="username">Username</label>
            <div class="input-with-icon">
                <i class="fas fa-user"></i>
                <input type="text" id="username" name="username" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <div class="input-with-icon">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-with-icon">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" required>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Register
        </button>
    </form>
    <p class="form-footer">
        Already have an account? <a href="login.php">Login</a>
    </p>
</div>

<?php require_once 'footer.php'; ?> 