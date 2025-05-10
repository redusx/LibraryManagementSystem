<?php
require_once 'header.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$books = [];

if (!empty($search)) {
    try {
        $stmt = $pdo->prepare("SELECT b.*, u.username as reserved_by 
                              FROM books b 
                              LEFT JOIN users u ON b.reserved_by_user_id = u.id 
                              WHERE b.title LIKE ? OR b.author LIKE ?");
        $searchTerm = "%$search%";
        $stmt->execute([$searchTerm, $searchTerm]);
        $books = $stmt->fetchAll();
    } catch (PDOException $e) {
        $error = "Search failed";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reserve_book'])) {
    $bookId = $_POST['book_id'];
    $userId = $_SESSION['user_id'];
    
    try {
        $stmt = $pdo->prepare("UPDATE books SET reserved_by_user_id = ? WHERE id = ? AND reserved_by_user_id IS NULL");
        $stmt->execute([$userId, $bookId]);
        header("Location: search.php?search=" . urlencode($search));
        exit();
    } catch (PDOException $e) {
        $error = "Failed to reserve book";
    }
}
?>

<div class="form-container">
    <h2>Search Books</h2>

    <form method="GET" action="" class="search-form">
        <div class="form-group">
            <div class="input-with-icon">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by title or author">
            </div>
            <button type="submit"><i class="fas fa-search"></i> Search</button>
        </div>
    </form>

    <?php if (isset($error)): ?>
        <p class="error"><i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if (!empty($books)): ?>
        <div class="books-list">
            <?php foreach ($books as $book): ?>
                <div class="book-item">
                    <h3><i class="fas fa-book"></i> <?php echo htmlspecialchars($book['title']); ?></h3>
                    <p><i class="fas fa-user-edit"></i> Author: <?php echo htmlspecialchars($book['author']); ?></p>
                    <?php if ($book['isbn']): ?>
                        <p><i class="fas fa-barcode"></i> ISBN: <?php echo htmlspecialchars($book['isbn']); ?></p>
                    <?php endif; ?>
                    
                    <?php if ($book['reserved_by_user_id']): ?>
                        <p class="reserved"><i class="fas fa-lock"></i> Reserved by: <?php echo htmlspecialchars($book['reserved_by']); ?></p>
                    <?php else: ?>
                        <form method="POST" action="" class="reserve-form">
                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                            <button type="submit" name="reserve_book"><i class="fas fa-bookmark"></i> Reserve</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif (!empty($search)): ?>
        <p class="no-results"><i class="fas fa-search"></i> No books found matching your search.</p>
    <?php endif; ?>
</div>

<?php require_once 'footer.php'; ?> 