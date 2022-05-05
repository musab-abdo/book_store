<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_categories'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $sub_cat = $_POST['sub_cat'];


   $select_product_name = mysqli_query($conn, "SELECT name FROM `categories` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'categories name already added';
   }else{
      $add_categories_query = mysqli_query($conn, "INSERT INTO `categories`(name, sub_cat) VALUES('$name', '$sub_cat')") or die('query failed');

   }
   if(isset($_GET['delete'])){
      $delete_id = $_GET['delete'];
      $delete_name_query = mysqli_query($conn, "SELECT name FROM `categories` WHERE id = '$delete_id'") or die('query failed');
      
      mysqli_query($conn, "DELETE FROM `categories` WHERE id = '$delete_id'") or die('query failed');
      header('location:admin_categories.php');
   }
   header('location:admin_categories.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title">categories </h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>add categories</h3>
      <input type="text" name="name" class="box" placeholder="enter name of categorie" required>
      <input type="text" name="sub_cat" class="box" placeholder="enter sub_categorie " required>
      <input type="submit" value="add categorie" name="add_categories" class="btn">
   </form>

</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-categories">

   <div class="box-container">

      <?php
         $select_categories = mysqli_query($conn, "SELECT * FROM `categories`") or die('query failed');
         if(mysqli_num_rows($select_categories) > 0){
            while($fetch_categories = mysqli_fetch_assoc($select_categories)){
      ?>
      <div class="box">
         
         <div class="name"><?php echo $fetch_categories['name']; ?></div>
         
         <a href="admin_categories.php?update=<?php echo $fetch_categories['id']; ?>" class="option-btn">update</a>
         <a href="admin_categories.php?delete=<?php echo $fetch_categories['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no categories added yet!</p>';
      }
      ?>
   </div>

</section>










<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>