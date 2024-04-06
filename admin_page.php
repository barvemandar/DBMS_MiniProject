<?php 
include 'config.php';

$message = array(); // Initialize the message array

if(isset($_POST['add_product'])){
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_FILES['product_image']['name'];
   $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
   $product_image_folder = 'uploaded_img/'.$product_image;

   if(empty($product_name) || empty($product_price) || empty($product_image)){
      $message[] = 'Please fill out all details.';
   }else{
      $insert = "INSERT INTO item(title, price, pic) VALUES('$product_name', '$product_price', '$product_image')";
      $upload = mysqli_query($conn, $insert);
      if($upload){
         move_uploaded_file($product_image_tmp_name, $product_image_folder);
         $message[] = 'New item added successfully.';
      }else{
         $message[] = 'Could not add the item.';
      }
   }
}

if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM item WHERE id = $id");
   header('location:admin_page.php');
   exit();
}; 

$select = mysqli_query($conn, "SELECT * FROM item");

// Calculate salary statistics
$result = mysqli_query($conn, "SELECT MIN(price) AS min_price, MAX(price) AS max_price, AVG(price) AS avg_price FROM item");
$salary_stats = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Page</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<style>
     .salary-box {
    background-color: #ffe0b3;
    padding: 1.5rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.1); 
    margin-top: 2rem; 
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center; 
}

.salary-box h3 {
    color: #5F0F40; 
    margin-bottom: 1rem;
    font-size: 2rem;
}

.salary-box p {
    color: #5F0F40; 
    margin-bottom: 0.5rem;
    font-size: 1.6rem;
}


</style>
<body>
   <?php
   if(isset($message)){
      foreach($message as $msg){
         echo '<span class="message">'.$msg.'</span>';
      }
   }
   ?>
   
   <div class="container">
      <div class="admin-product-form-container">
         <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <h3>Add a New Dish to the Menu</h3>
            <input type="text" placeholder="Dish Title" name="product_name" class="box">
            <input type="number" placeholder="Price" name="product_price" class="box">
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
            <input type="submit" class="btn" name="add_product" value="Add to Menu">
         </form>
      </div>

      <div class="salary-box">
         <h3>Salary Statistics</h3>
         <?php
         if ($salary_stats['min_price'] !== null && $salary_stats['max_price'] !== null && $salary_stats['avg_price'] !== null) {
            echo "<p>Minimum Price: ₹" . $salary_stats['min_price'] . "/-</p>";
            echo "<p>Maximum Price: ₹" . $salary_stats['max_price'] . "/-</p>";
            echo "<p>Average Price: ₹" . round($salary_stats['avg_price'], 2) . "/-</p>";
         } else {
            echo "<p>No price data available.</p>";
         }
         ?>
      </div>

      <div class="product-display">
         <table class="product-display-table">
            <thead>
               <tr>
                  <th>Dish</th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Action</th>
               </tr>
            </thead>
            <?php while($row = mysqli_fetch_assoc($select)){ ?>
            <tr>
               <td><img src="uploaded_img/<?php echo $row['pic']; ?>" height="100" alt=""></td>
               <td><?php echo $row['title']; ?></td>
               <td>₹<?php echo $row['price']; ?>/-</td>
               <td>
                  <a class="btn" href='admin_update.php?edit=<?php echo $row['id']; ?>'> <i class="fas fa-edit"></i> Edit </a>
                  <a class="btn" href='admin_page.php?delete=<?php echo $row['id']; ?>'> <i class="fas fa-trash"></i> Delete </a>
               </td>
            </tr>
            <?php } ?>
         </table>
      </div>
   </div>
</body>
</html>
