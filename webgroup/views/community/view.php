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
        /* button {
            padding: 8px 12px;
        } */
        /* Table Styling */
.table {
    margin: auto;
    width: 96%;
    border-collapse: collapse;
    background-color: white;
    border-radius: 8px;
    overflow: hidden;

    

}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    font-family: 'poppins', sans-serif;
   
    
}
td a {
    color: #0d3b66;
    text-decoration: none;
    font-weight: 500;

    
}

th {
    background-color: #f0d78c;
    color: #333;
    font-weight: bold;
}

tr:hover {
    background-color: #90d076;
    transition: background-color 0.2s ease;
}

form {
    display: inline-block;
    
    
}
.nav-button {
    padding: 9px 14px;
    cursor: pointer;
    background-color: #53aa43;
    border: none;
    color: white;
    border-radius: 5px;
    font-size: 14px;
    transition: background-color 0.2s ease;
}

.nav-button:hover {
    background-color: #296b8e;
}

.card {
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin: 10px 0;
    padding: 15px;
    border: 2px solid black;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    font-family: 'poppins', sans-serif;
    font-size: 13px;

}

.card a {
    color: #0d3b66;
    text-decoration: none;
    font-weight: bold;
}

.card a:hover {
    color: green;
}

.card p {
    margin: 5px 0;
    color: #555;
    line-height: 1.6;

}
.delete-filebutton {
    padding: 6px 7px;
    cursor: pointer;
    background-color: red;
    border: none;
    color: black;
    border-radius: 5px;
    font-size: 13px;
   
    
}

.namebord {
   
    margin: 20px auto;
    width: 97%;
    text-align: center;
    border-radius: 8px;
    padding: 1px;
    font-family: 'poppins', sans-serif;
    font-size: 30px;
    font-weight: 500;
    border-radius: 15px;
}
.name {
    background-color: white;
    margin: 20px auto;
    width: 54%;
    border-radius: 15px;
}
.p {
    margin: 0px;
}

.dis {
    width: 95%;
    margin: 5px auto;
    padding: 4px;
    font-family: 'poppins', sans-serif;
    font-size: 16px;
    font-weight: 500;
    
}   
.buttonsbar {
    width: 97%;
    margin: auto;
    
}
@media (max-width: 768px) {
    .card {
        margin: 15px 5px;
    }
}

    </style>
</head>
<body>
    <div class="namebord" style="background-color: <?= $community['color'] ?>;">

    <div class="name">
    <p><?= htmlspecialchars($community['c_name']) ?></p>
    </div>
    </div>


    <div class="dis"><p><?= htmlspecialchars($community['description']) ?></p>  </div>

    <div class="buttonsbar">
    <form method="POST" action="upload.php">
        <input type="hidden" name="community_id" value="<?=($community_id) ?>">
        <button class="nav-button" type="submit">Upload a File</button>
    </form>

    <form action="./members.php" method="GET">
        <input type="hidden" name="community_id" value="<?= ($community_id) ?>">
        <button class="nav-button" type="submit">Community members</button>
    </form>

    <form action="chat.php" method="POST">
        <input type="hidden" name="community_id" value="<?= ($community_id) ?>">
        <input type="hidden" name="community_name" value="<?= ($community['c_name']) ?>">
        <button class="nav-button" type="submit">Group Chat</button>
    </form>
    <form method="POST" action="./gallery.php">
        <input type="hidden" name="community_id" value="<?= $community_id ?>">
        <button class="nav-button" type="submit">Gallery</button>
        </form>
    
        <form method="POST" action="./leave_community.php">
    <input type="hidden" name="community_id" value="<?= htmlspecialchars($community_id) ?>">
    <button class="nav-button" type="submit">Leave Community</button>
</form>




        <?php
    $current_owner = $community['current_owner_id']; 
    //echo "Current owner is: $current_owner";

    if ($current_owner == $_SESSION['user_id']) {
        echo '<form method="POST" action="./editcommunity.php">
            <input type="hidden" name="community_id" value="' . htmlspecialchars($community_id) . '">
            <button class="editbutton" type="submit">Edit Community</button>
            </form>';
    }

    
    ?>

    </div>
    <h2>Files</h2>
   
    <form method="POST" action="">
        <input type="hidden" name="community_id" value="<?= htmlspecialchars($community_id) ?>">
        <input type="text" name="search" placeholder="Search files here" value="<?= htmlspecialchars($searchTerm) ?>">
        <button class="searchbutton" type="submit">Search</button>
    </form>

    <div class="container my-4">
    <table class="table desktop-view">
        <thead>
            <tr>
                <th scope="col">Description</th>
                <th style="width: 20%;" scope="col">Uploaded by</th>
                <th scope="col">File Download</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($files) > 0): ?>
                <?php foreach ($files as $file): ?>
                    <tr>
                    <td><?= htmlspecialchars($file['description']) ?></td>
                    <td>
                        <p>
                        <a href="../user/userprofile.php?userid=<?= urlencode($file['uploaded_by']) ?>">
                        <?= htmlspecialchars($file['uploader_name']) ?>
                        </a>
                        </p><p> <?= htmlspecialchars($file['uploaded_at']) ?></p>
                    </td>
                    <td>
                        <a href="<?= htmlspecialchars($file['file_path']) ?>" download target="_blank">
                                <?= htmlspecialchars($file['name_for_file']) ?>
                        </a> <br>(<?= htmlspecialchars($file['file_type']) ?>)
                    </td>
                        <?php if ($current_owner == $_SESSION['user_id']): ?>
                            <td>
                                <form method="POST" action="./deletefile.php">
                                    <input type="hidden" name="file_id" value="<?= htmlspecialchars($file['file_id']) ?>">
                                    <button class="delete-filebutton" type="submit">Delete</button>
                                </form>
                            </td>
                        <?php endif; ?>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3">No uploaded files. Upload files and get started!</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    
    <div class="mobile-view">
        <?php if (count($files) > 0): ?>
        <?php foreach ($files as $file): ?>
                <div class="card my-2">
                    <a href="<?= htmlspecialchars($file['file_path']) ?>" download target="_blank">
                        <?= htmlspecialchars($file['name_for_file']) ?>
                    </a> (<?= htmlspecialchars($file['file_type']) ?>)
                    <p><?= htmlspecialchars($file['description']) ?></p>
                    <p>
                        by <a href="../user/userprofile.php?userid=<?= urlencode($file['uploaded_by']) ?>">
                            <?= htmlspecialchars($file['uploader_name']) ?>
                        </a>
                    </p>
                    <p><?= htmlspecialchars($file['uploaded_at']) ?></p>
                    <?php if ($current_owner == $_SESSION['user_id']): ?>
                        <form method="POST" action="./deletefile.php">
                            <input type="hidden" name="file_id" value="<?= htmlspecialchars($file['file_id']) ?>">
                            <button class="delete-filebutton" type="submit">Delete</button>
                        </form>
                    <?php endif; ?>
                </div>
        <?php endforeach; ?>
        <?php else: ?>
            <p>No file.</p>
        <?php endif; ?>
    </div>
</div>

<style>
    .mobile-view {
        display: none;
    }
    .desktop-view {
        display: table;
    }

    @media (max-width: 768px) {
        .mobile-view {
            display: block;
        }
        .desktop-view {
            display: none;
        }
    }
</style>


  
</body>
</html>
