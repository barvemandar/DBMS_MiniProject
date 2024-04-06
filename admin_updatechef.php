<?php

@include 'config.php';

$id = $_GET['edit'];

if(isset($_POST['update_details'])){

   $name = $_POST['name'];
   $salary = $_POST['salary'];

   if(empty($salary)){
      $message[] = 'add salary';    
   }else{
      $update_data = "UPDATE chef SET  salary= $salary  WHERE cname = '$id'";
      $upload = mysqli_query($conn, $update_data);

      if($upload){
         header('location:chef_add.php');
      }else{
         $$message[] = 'Salary amount must be provided'; 
      }
   }
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
   if(isset($message)){
      foreach($message as $message){
         echo '<span class="message">'.$message.'</span>';
      }
   }
?>
<div class="container">
<div class="admin-product-form-container centered">
    <?php
      $select = mysqli_query($conn, "SELECT * FROM chef WHERE cname = '$id'");
      while($row = mysqli_fetch_assoc($select)){
   ?> 
   <form action="" method="post" enctype="multipart/form-data">
      <h3 class="title">update Salary of Chef: <?php echo $row['cname'];  ?></h3>
      <input type="number" min="0" class="box" name="salary" value="<?php echo $row['salary']; ?>" placeholder="enter the updated salary amount">
      <input type="submit" value="update details" name="update_details" class="btn">
      <a href="chef_add.php" class="btn">Back</a>
   </form>
   <?php }; ?>
</div>
</div>
</body>
</html>