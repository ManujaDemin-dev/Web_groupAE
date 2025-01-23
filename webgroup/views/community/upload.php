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
    <style>
    body {
           
           font-family: 'Poppins', sans-serif;
           margin: 0;
           padding: 0;
         
       }

       h1 {
           text-align: center;
           color: black;
       }

       .formm {
          
           margin: auto;
           background-color: #fff;
           padding: 20px;
           border-radius: 8px;
           box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
           max-width: 800px;
           box-sizing: border-box;
       }

       label {
           display: block;
           margin-bottom: 5px;
           color: black;
           font-weight: bold;
       }

       input[type="file"],
       input[type="text"],
       textarea {
           width: 100%;
           padding: 8px;
           margin-bottom: 15px;
           border: 1px solid #ccc;
           border-radius: 4px;
           font-size: 16px;
           box-sizing: border-box;
           
       }

       textarea {
           resize: none;
           height: 120px;
       }

       .sub {
           color: white;
           border: none;
           padding: 10px 15px;
           border-radius: 4px;
           cursor: pointer;
           width: 40%;
           background-color: #0d3b66;
           transition:  transform 0.2s ease;
           font-size: 16px;
       }

       .sub:hover {
           background-color:  #90D076; 
           color: black;
           
       }
       .nav-button {
           margin: 20px 30px;
           padding: 8px 10px;
           background-color: #0d3b66;
           color: white;
           border: none;
           border-radius: 4px;
           cursor: pointer;
           text-decoration: none;
           font-size: 14px;
           
           transition:  transform 0.2s ease;
       }

       .nav-button:hover {
           background-color:  #90D076; 
           color: black;
       }
       .textho {
           text-align: center;
           color: black;
           font-family: 'Poppins', sans-serif;
       }
      
       @media (max-width: 480px) {
           body {
               padding: 10px;
           }

           .formm {
               width: 100%;
               padding: 0px;
           }

           .sub {
               font-size: 14px;
               padding: 8px 10px;
           }

           input[type="file"],
       input[type="text"],
       textarea {
           width: 100%;
           padding: 8px;
           
           font-size: 18px;
           
           
       }

       textarea {
           resize: none;
           height: 180px;
           font-size: 14px;

       }

       }
   </style>
</head>
<body>

    <form  action="./view.php" method="POST">
        <input type="hidden" name="community_id" value="<?= $community_id ?>">
        <button  class="nav-button" type="submit">Back to community</button>
    </form>

    
    <h1>Upload a File</h1>
    <p class="textho">Choose a file to upload and share it easily with your community!</p>
    <form class="formm" method="POST" enctype="multipart/form-data">
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
        <button class="sub" type="submit">Upload</button>
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
