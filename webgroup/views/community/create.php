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
 
                
           
        </style>
</head>
<body>
    <h1>Create Community</h1>
    <form class="form" action="" method="POST">
        <label>Community Name</label>
        <input class="formin" type="text" name="c_name" maxlength="45" required><br><br>
        <label>Commmunity Description</label> <br>
        <textarea class="formin" name="description" rows="7" maxlength="400" required></textarea><br><br>
        <label for="color">Select a main color for your Community</label>
        <input class="formcolor" type="color" id="color" name="color" value="#ff0000"><br><br>

        <button class="btn" type="submit">Create</button>
    </form> 
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
</body>
</html>
