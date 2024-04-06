<?php 
include 'config.php';
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
   
   <?php

   $select = mysqli_query($conn, "SELECT * FROM logs");
   
   ?>
   <div class="product-display">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>name</th>
            <th>Time Stamp</th>
         </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><?php echo $row['cname']; ?></td>
            <td><?php echo $row['cdate']; ?></td>
         </tr>
      <?php } ?>
      </table>
   </div>

</div>


</body>
</html>