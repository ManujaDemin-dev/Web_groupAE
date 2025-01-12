<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}
include '../usernav.php';

if (isset($_SESSION['message'])) {
    echo "<p>" . htmlspecialchars($_SESSION['message']) . "</p>";
    unset($_SESSION['message']); 
}

// $username = $_SESSION['username'];

$community_id = $_POST['community_id'];
$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : ''; 


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



// if ($searchTerm) {
//     $filesQuery = "SELECT * FROM files WHERE community_id = :community_id AND name_for_file LIKE :searchTerm";
//     $filesStmt = $pdo->prepare($filesQuery);
//     $filesStmt->execute([
//         'community_id' => $community_id,
//         'searchTerm' => "%$searchTerm%"
//     ]);
    
// } else {
//     $filesQuery = "SELECT * FROM files WHERE community_id = :community_id ORDER BY file_id DESC";
//     $filesStmt = $pdo->prepare($filesQuery);
//     $filesStmt->execute(['community_id' => $community_id]);
// }


if ($searchTerm) {
    $filesQuery = "SELECT files.*, users.name AS uploader_name FROM files 
                   JOIN users ON files.uploaded_by = users.user_id WHERE files.community_id = :community_id 
                   AND files.name_for_file LIKE :searchTerm";
    $filesStmt = $pdo->prepare($filesQuery);
    $filesStmt->execute([
        'community_id' => $community_id,
        'searchTerm' => "%$searchTerm%"
    ]);
} else {
    $filesQuery = "SELECT files.*, users.name AS uploader_name FROM files 
                   JOIN users ON files.uploaded_by = users.user_id 
                   WHERE files.community_id = :community_id 
                   ORDER BY files.file_id DESC";
    $filesStmt = $pdo->prepare($filesQuery);
    $filesStmt->execute(['community_id' => $community_id]);
}

$files = $filesStmt->fetchAll(PDO::FETCH_ASSOC);


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
           
            margin: 0;
            padding: 0;
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

    
    <form method="POST" action="upload.php">
        <input type="hidden" name="community_id" value="<?=($community_id) ?>">
        <button type="submit">Upload a File</button>
    </form>

    <form action="./members.php" method="GET">
        <input type="hidden" name="community_id" value="<?= ($community_id) ?>">
        <button type="submit">Community members</button>
    </form>

    <form action="chat.php" method="POST">
        <input type="hidden" name="community_id" value="<?= ($community_id) ?>">
        <input type="hidden" name="community_name" value="<?= ($community['c_name']) ?>">
        <button type="submit">Group Chat</button>
    </form>
    <form method="POST" action="./gallery.php">
        <input type="hidden" name="community_id" value="<?= $community_id ?>">
        <button type="submit">Gallery</button>
        </form>
    
        <form method="POST" action="./leave_community.php">
    <input type="hidden" name="community_id" value="<?= htmlspecialchars($community_id) ?>">
    <button type="submit">Leave Community</button>
</form>




        <?php
    $current_owner = $community['current_owner_id']; 
    //echo "Current owner is: $current_owner";

    if ($current_owner == $_SESSION['user_id']) {
        echo '<form method="POST" action="./editcommunity.php">
            <input type="hidden" name="community_id" value="' . htmlspecialchars($community_id) . '">
            <button type="submit">Edit Community</button>
            </form>';
    }
    ?>
    <h2>Files</h2>
   
    <form method="POST" action="">
        <input type="hidden" name="community_id" value="<?= htmlspecialchars($community_id) ?>">
        <input type="text" name="search" placeholder="Search files here" value="<?= htmlspecialchars($searchTerm) ?>">
        <button type="submit">Search</button>
    </form>

    <ul>
        <?php if (count($files) > 0): ?>
            <?php foreach ($files as $file ): ?>



                <div class="card">
                    <a href="<?= htmlspecialchars($file['file_path']) ?>" download target="_blank">
                        <?= htmlspecialchars($file['name_for_file']) ?>
                    </a> (<?= htmlspecialchars($file['file_type']) ?>)
                    <p><?= htmlspecialchars($file['description']) ?></p>
                    <p>by <a href="../user/userprofile.php?name=<?= urlencode($file['uploader_name']) ?>"><?= htmlspecialchars($file['uploader_name']) ?></a></p>
                    <p> <?= htmlspecialchars($file['uploaded_at']) ?></p>
                    
                     
                    
                </div>


            <?php endforeach; ?>
        <?php else: ?>
            <li>No files found.</li>
        <?php endif; ?>
    </ul>

  

  
   <a href="upload.php?community_id=<?= $community_id ?>">Upload Files</a>
  
    
    <a href="../community/chat.php?community_id=<?= $community_id ?>&community_name=<?= urlencode($community['c_name']) ?>">Group Chat</a>
    
    
    

  //  <a href="members.php?community_id=<?= $community_id ?>">Community Members</a>
</body>
</html>
