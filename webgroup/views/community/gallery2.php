<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $community_id = $_POST['community_id'];

    // Fetch community details
    $query = "SELECT * FROM communities WHERE community_id = :community_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['community_id' => $community_id]);
    $community = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set session details
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];


// Simulate admin login for demonstration (Replace with real authentication)
$_SESSION['is_admin'] = true; // Change to `false` to test non-admin view

// Fetch files from the database
$sql = "SELECT * FROM files ORDER BY uploaded_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Posts</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Community Posts</h1>
            <a class="upload-link" href="upload.php">Upload a File</a>
        </div>
        <?php if (count($result) > 0): ?>
            <?php foreach ($result as $row): ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($row['file_path']) ?>" alt="Uploaded Image">
                    <div class="card-body">
                        <div class="card-title">Uploader: <?= htmlspecialchars($row['uploader']) ?></div>
                        <div class="card-meta">Uploaded At: <?= $row['uploaded_at'] ?></div>
                        <div class="card-description"><?= htmlspecialchars($row['description']) ?></div>
                        <div class="card-actions">
                            <div class="like-section" onclick="toggleLike(<?= $row['file_id'] ?>, this)">
                                ❤️ <span><?= $row['likes'] ?></span>
                            </div>

                            <?php if ($_SESSION['is_admin']): ?>
                                <form method="POST" action="delete_post.php" style="display:inline;">
                                    <input type="hidden" name="file_id" value="<?= $row['file_id'] ?>">
                                    <button type="submit" class="delete-button">Delete</button>
                                </form>
                            <?php endif; ?>
                        </div>

                        <!-- Comments Section -->
                        <div class="comments-section">
                            <h4>Comments</h4>
                            <?php
                            $comment_query = $conn->prepare(
                                "SELECT c.comment, u.username 
                                FROM comments c 
                                JOIN users u ON c.user_id = u.user_id 
                                WHERE c.file_id = :file_id"
                            );
                            $comment_query->execute(['file_id' => $row['file_id']]);
                            $comments = $comment_query->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($comments as $comment): ?>
                                <div class="comment">
                                    <span class="username"><?= htmlspecialchars($comment['username']) ?>:</span>
                                    <?= htmlspecialchars($comment['comment']) ?>
                                </div>
                            <?php endforeach; ?>

                            <!-- Add Comment -->
                            <form action="add_comment.php" method="POST" class="add-comment">
                                <textarea name="comment" placeholder="Write a comment..." required></textarea>
                                <input type="hidden" name="file_id" value="<?= $row['file_id'] ?>">
                                <button type="submit">Add Comment</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No files uploaded yet. Be the first to <a href="upload.php">upload something</a>!</p>
        <?php endif; ?>
    </div>
    <script>
        function toggleLike(fileId, element) {
            fetch(`toggle_like.php?file_id=${fileId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let likesCount = element.querySelector("span");
                        let currentCount = parseInt(likesCount.textContent);

                        if (data.action === 'like') {
                            likesCount.textContent = currentCount + 1;
                            element.classList.add('liked'); // Optional visual change
                        } else if (data.action === 'unlike') {
                            likesCount.textContent = currentCount - 1;
                            element.classList.remove('liked'); // Optional visual change
                        }
                    } else {
                        alert(data.message || 'Error toggling like.');
                    }
                })
                .catch(err => console.error(err));
        }
    </script>
</body>

</html>
