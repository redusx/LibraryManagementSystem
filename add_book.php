<?php
require_once 'header.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $isbn = trim($_POST['isbn']);
    
    $errors = [];
    
    if (empty($title)) {
        $errors[] = "Title is required";
    }
    if (empty($author)) {
        $errors[] = "Author is required";
    }
    
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO books (title, author, isbn) VALUES (?, ?, ?)");
            $stmt->execute([$title, $author, $isbn]);
            header("Location: search.php");
            exit();
        } catch (PDOException $e) {
            $errors[] = "Failed to add book";
        }
    }
}
?>

<div class="form-container">
    <h2>Add New Book</h2>

    <?php if (!empty($errors)): ?>
        <div class="errors">
            <?php foreach ($errors as $error): ?>
                <p class="error"><i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="" class="form">
        <div class="form-group">
            <label for="title">Title:</label>
            <div class="input-with-icon">
                <i class="fas fa-book"></i>
                <input type="text" id="title" name="title" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="author">Author:</label>
            <div class="input-with-icon">
                <i class="fas fa-user-edit"></i>
                <input type="text" id="author" name="author" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="isbn">ISBN (optional):</label>
            <div class="input-with-icon">
                <i class="fas fa-barcode"></i>
                <input type="text" id="isbn" name="isbn">
            </div>
        </div>
        
        <button type="submit"><i class="fas fa-plus"></i> Add Book</button>
    </form>
</div>

<?php require_once 'footer.php'; ?> 