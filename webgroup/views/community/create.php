<?php
session_start();
include '../../includes/db.php';
include '../../includes/functions.php';

if (!isLoggedIn()) {
    redirect('../../index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $c_name = $_POST['c_name'];
    $description = $_POST['description'];
    $category_id = $_GET['category_id'];
    $color = $_POST['color'];

    // Start transaction to ensure both queries succeed together
    $pdo->beginTransaction();
  // for community user table 
    try {
        // Insert the new community into the communities table
        $query = "INSERT INTO communities (c_name, description, category_id, created_by, current_owner_id, color) 
                  VALUES (:c_name, :description, :category_id, :created_by, :current_owner_id, :color)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'c_name' => $c_name,
            'description' => $description,
            'category_id' => $category_id,
            'created_by' => $_SESSION['user_id'],
            'current_owner_id' => $_SESSION['user_id'],
            'color' => $color
        ]);

        // Get the ID of the newly created community
        $community_id = $pdo->lastInsertId();

        // Insert the creator into the community_members table
        $memberQuery = "INSERT INTO community_members (community_id, user_id, joined_at) 
                        VALUES (:community_id, :user_id, now())";
        $memberStmt = $pdo->prepare($memberQuery);
        $memberStmt->execute([
            'community_id' => $community_id,
            'user_id' => $_SESSION['user_id'],
            // 'joined_at' => date('Y-m-d H:i:s')
        ]);

        // Commit transaction
        $pdo->commit();

        // Redirect back to the category page
        // redirect("index.php?category_id=$category_id");
        //redirect("view.php?community_id=$community_id");



$data = array(
    'community_id' => $community_id
    
);


$jsonData = json_encode($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
</head>
<body>
   
    <form id="postForm" action="./view.php" method="post">
        <?php
       
        foreach ($data as $key => $value) {
            echo "<input type='hidden' name='".htmlspecialchars($key)."' value='".htmlspecialchars($value)."'>";
        }
        ?>
    </form>

    <!-- JavaScript to automatically submit the form -->
    <script type="text/javascript">
        document.getElementById('postForm').submit();
    </script>
</body>
</html>




<?php

    } catch (PDOException $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        $error = "Error creating community: " . $e->getMessage();
    }
}

include '../usernav.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Community</title>
    <style>
/*   
        body {
            
            margin: 0;
            padding: 0;
            
        }

        .form {
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
            padding: 20px;
            border-radius: 10px;
            margin: auto;
            width: 380px;
        }

        .form label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .formin,
        .formcolor {
            padding: 10px;
            border-radius: 5px;
            width: 350px;
            margin-bottom: 15px;
            font-size: 16px;
        }


        .formcolor {
            width: 90%;
            height: 40px;
            padding: 0;
            appearance: none; 
            border-radius: 10px;
            cursor: pointer;
            background-color: transparent; 
        }


        
        .btn {
            padding: 10px;
            border: none;
            border-radius: 10px;
            border: 3px solid blue;
            background-color: blue;
            color: white;
            font-weight: bold;
            
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: white;
            color:blue;
        }
  */
  @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    body {
      font-family: poppins;
      margin: 0;
      padding: 0;
      
     
   
    }

    .container {
     margin-top: 20px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      margin: auto;
      width: 88%;
      max-width: 800px;
      padding: 20px;
 
    }

    .container h1 {
      font-size: 24px;
      margin-top: 10px;
      margin-bottom: 10px;
      text-align: center;
      color: #333;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-size: 15px;
      font-weight: bold;
      margin-bottom: 5px;
      color: #555;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 95%;
      padding: 10px;
      border: 1px solid black;
      border-radius: 4px;
      font-size: 14px;
      color: #333;
    }

    .form-group textarea {
      height: 100px;
      resize: none;
     
    }

    .form-group input[type="color"] {
      height: 50px;
      border: none;
      cursor: pointer;
      
    }

    .btn {
      display: block;
      width: 50%;
      padding: 10px;
      font-size: 16px;
      font-weight: bold;
      text-align: center;
      color: white;
      background-color: #0d3b66;;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 20px;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #0056b3;
    }

           
        </style>
</head>
<body>
<div class="container">
    <h1>Create Community</h1>
    <form class="form" action="" method="POST">
    <div class="form-group">
        <label>Community Name</label>
        <input class="formin" type="text" name="c_name" maxlength="45" required><br><br>
    </div>
    <div class="form-group">
        <label>Commmunity Description</label>
        <textarea class="formin" name="description" rows="7" maxlength="400" required></textarea><br><br>
    </div>
    <div class="form-group">
        <label for="color">Select a main color for your Community</label>

        <input class="formcolor" type="color" id="color" name="color" value="#ff0000"><br><br>
    </div>
        <button class="btn" type="submit">Create a Community</button>
    </form> 
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
</div>
</body>
</html>
