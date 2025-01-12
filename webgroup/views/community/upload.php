<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}
$community_id = $_POST['community_id'];
$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name_for_file'])) {
    $community_id = $_POST['community_id'];
    if (!empty($_FILES['file']['name'])) {
        $file = $_FILES['file'];
        $description = $_POST['description'];
        $name_for_file = $_POST['name_for_file'];
        

        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedImageExtensions = ['jpg', 'jpeg', 'png'];

    
        $isImage = in_array($fileExtension, $allowedImageExtensions);

        /*$uploadFolder = $isImage ? './uploads/images/' : './uploads/files/';*/

        if ($isImage) {
            $uploadFolder = './uploads/images/';
            $type = 'image';
        } else {
            $uploadFolder = './uploads/files/';
            $type = 'file';
        }

       
        }
        $newFileName = uniqid() . '.' . $fileExtension;
        $filePath = $uploadFolder . $newFileName;

   
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            
            $query = "INSERT INTO files (community_id, file_name,name_for_file, file_path, uploaded_by, uploader, file_type, description, type, uploaded_at) 
                      VALUES (:community_id, :file_name,:name_for_file, :file_path, :uploaded_by, :uploader, :file_type, :description, :type, NOW())";
            $stmt = $pdo->prepare($query);

            $stmt->execute([
                'community_id' => $community_id,
                'file_name' => $newFileName,
                'file_path' => $filePath,
                'uploaded_by' => $_SESSION['user_id'],
                'uploader' => $username,
                'file_type' => $fileExtension,
                'description' => $description,
                'type' => $type,
                'name_for_file' => $name_for_file,
                
            ]);

            echo "<form id='redirectForm' method='POST' action='./view.php'>
            <input type='hidden' name='community_id' value='" . htmlspecialchars($community_id) . "'>
        </form>
        <script>document.getElementById('redirectForm').submit();</script>";
        } else {
            $error = "File upload failed.";
        }
    } /*else {
        $error = "No file selected.";
    }*/
//}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
</head>
<body>

     <p>in this system if you are upload a imges it will shows only the wall and other files will be shows in commu.</p>
    <h1>Upload a File</h1>
    <form method="POST" enctype="multipart/form-data">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['community_id'])) {
            Echo "<input type='hidden' name='community_id' value='" . $_POST['community_id'] . "'>";
        }      
        ?>
        <label>Choose a File</label>
        <input type="file" name="file" required><br>
        <label>Name </label><br>
        <input type="text" name="name_for_file" required><br>
        <label>Description  200 charaters only</label><br><br>
        <textarea name="description" maxlength="200" ></textarea><br><br>
        <button type="submit">Upload</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>


    <script>
        function confirmJoin(event, form) {
            event.preventDefault(); 
             {
                form.submit(); 
            }
        }
    </script>
</body>
</html>
