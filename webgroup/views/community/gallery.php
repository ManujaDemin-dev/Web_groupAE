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

    // Check if the user is the owner
    $ownerQuery = "SELECT current_owner_id FROM communities WHERE community_id = :community_id";
    $ownerStmt = $pdo->prepare($ownerQuery);
    $ownerStmt->execute(['community_id' => $community_id]);
    $owner = $ownerStmt->fetch(PDO::FETCH_ASSOC);

    $isOwner = $user_id == $owner['current_owner_id'];

    // // Fetch community files
    // $filesQuery = "SELECT * FROM files WHERE community_id = 25 ORDER BY uploaded_at DESC";
    // $filesStmt = $pdo->prepare($filesQuery);
    // $filesStmt->execute(['community_id' => $community_id]);
    // $files = $filesStmt->fetchAll(PDO::FETCH_ASSOC);
    $filesQuery = "SELECT * FROM files WHERE community_id = :community_id ORDER BY uploaded_at DESC";
$filesStmt = $pdo->prepare($filesQuery);
$filesStmt->execute(['community_id' => $community_id]);

// Debugging the query result
if ($filesStmt->rowCount() > 0) {
    echo "Debug - Found " . $filesStmt->rowCount() . " files for Community ID: " . $community_id;
} else {
    echo "Debug - No files found for Community ID: " . $community_id;
    // Optionally, print the community ID
}
$files = $filesStmt->fetchAll(PDO::FETCH_ASSOC);

}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Gallery</title>
    <style>
         body {
            font-family: 'Arial', sans-serif;
            background: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
        }

        .header {
            text-align: center;
            padding: 20px;
            background: #007BFF;
            color: #fff;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 2em;
        }

        .upload-link {
            display: inline-block;
            text-decoration: none;
            background: #ff5722;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
            transition: background 0.3s ease;
        }

        .upload-link:hover {
            background: #e64a19;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .card img {
            width: 100%;
            max-height: auto;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }

        .card-description {
            margin-top: 10px;
            color: #555;
        }

        .card-meta {
            margin-top: 15px;
            font-size: 0.9em;
            color: #777;
        }

        .card-actions {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .like-section {
            display: flex;
            align-items: center;
            font-size: 1.2em;
            color: #ff5252;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .like-section span {
            margin-left: 5px;
            font-size: 1em;
            color: #555;
        }

        .like-section:hover {
            color: #ff1744;
        }

        .liked {
            color: #ff1744;
        }

        .delete-button {
            background: #e53935;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-button:hover {
            background: #d32f2f;
        }

        .comments-section {
            margin-top: 15px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 5px;
        }

        .comment {
            margin-bottom: 10px;
        }

        .comment .username {
            font-weight: bold;
        }

        .add-comment textarea {
            width: 100%;
            height: 50px;
            margin-top: 10px;
        }

        .add-comment button {
            margin-top: 5px;
            cursor: pointer;
        }
    </style>
    </style>
</head>
<body>
    <!-- <div class="container">
        <div class="header">
            <h1>Community Posts</h1>
            <a class="upload-link" href="upload.php">Upload a File</a>
        </div> -->

        <?php if (!empty($files)): ?>
            <?php foreach ($files as $row): ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($row['file_path']) ?>" alt="Uploaded Image">
                    <div class="card-body">
                        <div class="card-title">Uploader: <?= htmlspecialchars($row['uploader']) ?></div>
                        <div class="card-meta">Uploaded At: <?= htmlspecialchars($row['uploaded_at']) ?></div>
                        <div class="card-description"><?= htmlspecialchars($row['description']) ?></div>
                        <div class="card-actions">
                            <div class="like-section" data-file-id="<?= $row['file_id'] ?>" onclick="toggleLike(this)">
                                ❤️ <span><?= htmlspecialchars($row['likes']) ?></span>
                            </div>

                            <?php if ($isOwner): ?>
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
                            $commentQuery = $pdo->prepare("
                                SELECT c.comment, u.username 
                                FROM comments c 
                                JOIN users u ON c.user_id = u.user_id 
                                WHERE c.file_id = :file_id
                            ");
                            $commentQuery->execute(['file_id' => $row['file_id']]);
                            while ($comment = $commentQuery->fetch(PDO::FETCH_ASSOC)): ?>
                                <div class="comment">
                                    <span class="username"><?= htmlspecialchars($comment['username']) ?>:</span>
                                    <?= htmlspecialchars($comment['comment']) ?>
                                </div>
                            <?php endwhile; ?>

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
        function toggleLike(element) {
            const fileId = element.getAttribute('data-file-id');
            fetch(`toggle_like.php?file_id=${fileId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const likesCount = element.querySelector("span");
                        const currentCount = parseInt(likesCount.textContent, 10);

                        if (data.action === 'like') {
                            likesCount.textContent = currentCount + 1;
                            element.classList.add('liked');
                        } else if (data.action === 'unlike') {
                            likesCount.textContent = currentCount - 1;
                            element.classList.remove('liked');
                        }
                    } else {
                        alert(data.message || 'Error toggling like.');
                    }
                })
                .catch(err => console.error('Error:', err));
        }
    </script>
</body>
</html>
