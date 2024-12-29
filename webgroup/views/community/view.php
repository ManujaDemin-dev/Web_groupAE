<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}

$community_id = $_POST['community_id'];
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : ''; 


$query = "SELECT * FROM communities WHERE community_id = :community_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['community_id' => $community_id]);
$community = $stmt->fetch(PDO::FETCH_ASSOC);

$membersQuery = "SELECT users.name, users.email FROM community_members 
                 JOIN users ON community_members.user_id = users.user_id 
                 WHERE community_members.community_id = :community_id";
$membersStmt = $pdo->prepare($membersQuery);
$membersStmt->execute(['community_id' => $community_id]);
$members = $membersStmt->fetchAll(PDO::FETCH_ASSOC);




if ($searchTerm) {
    $filesQuery = "SELECT * FROM files WHERE community_id = :community_id AND name_for_file LIKE :searchTerm";
    $filesStmt = $pdo->prepare($filesQuery);
    $filesStmt->execute([
        'community_id' => $community_id,
        'searchTerm' => "%$searchTerm%"
    ]);
} else {
    $filesQuery = "SELECT * FROM files WHERE community_id = :community_id ORDER BY file_id DESC";
    $filesStmt = $pdo->prepare($filesQuery);
    $filesStmt->execute(['community_id' => $community_id]);
}
$files = $filesStmt->fetchAll(PDO::FETCH_ASSOC);

include '../userhead.html';
//include '../communityhead.html' // navbar  2  we can add nav bar as bottom bar or side bar

// normal nav bar
// community nav bar
//special button for community owner
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($community['c_name']) ?> Community</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-top: 100px;
        }
        input[type="text"] {
            padding: 8px;
            margin-bottom: 10px;
            width: 300px;
        }
        button {
            padding: 8px 12px;
        }
    </style>
</head>
<body>
    <h1><?= htmlspecialchars($community['c_name']) ?></h1>
    <p><?= htmlspecialchars($community['description']) ?></p>

    
    <h2>Files</h2>
   
    <form method="GET" action="">
        <input type="hidden" name="community_id" value="<?= htmlspecialchars($community_id) ?>">
        <input type="text" name="search" placeholder="Search files here" value="<?= htmlspecialchars($searchTerm) ?>">
        <button type="submit">Search</button>
    </form>

    <ul>
        <?php if (count($files) > 0): ?>
            <?php foreach ($files as $file): ?>



                <div class="card">
                    <a href="<?= htmlspecialchars($file['file_path']) ?>" download target="_blank">
                        <?= htmlspecialchars($file['name_for_file']) ?>
                    </a> (<?= htmlspecialchars($file['file_type']) ?>)
                    <p><?= htmlspecialchars($file['description']) ?></p>
                    <p>by <?= htmlspecialchars($file['uploaded_by']) ?></p>
                    <p> <?= htmlspecialchars($file['uploaded_at']) ?></p>
                    
                    
                    
                </div>


            <?php endforeach; ?>
        <?php else: ?>
            <li>No files found.</li>
        <?php endif; ?>
    </ul>

    <a href="./upload.php?community_id=<?= $community_id ?>">Upload a File</a><br>
    <a href="delete.php?community_id=<?= $community_id ?>">Delete Community</a>
    <a href="index.php">All Communities</a>
   mokada karnne owner nam thaw nav bar ekak hari pannel ekek hari dann wenawa button set ekk.meyana widiyat comment dann wen na. kamk na<br> edit communit / del commu / del files/  owener change
    <a href="edit.php?community_id=<?= $community_id ?>">Edit Community</a>
    <a href="../community/chat.php?community_id=<?= $community_id ?>&community_name=<?= urlencode($community['c_name']) ?>">Group Chat</a>
    <form method="POST" action="./gallery.php">
        <input type="hidden" name="community_id" value="<?= $community_id ?>">
        <button type="submit">Gallery</button>
        </form>
    



    <a href="members.php?community_id=<?= $community_id ?>">Community Members</a>
</body>
</html>
