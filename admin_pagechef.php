<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style.css">
</head>
<style>
    .salary-box {
   background-color: var(--bg-color);
   border: var(--border);
   border-radius: 20px;
   padding: 2rem;
   margin-top: 2rem;
}

.salary-box h3 {
   color: var(--black);
   font-size: 4rem;
   text-align: center;
   margin-bottom: 1.5rem;
}

.salary-box p {
   color: var(--black);
   font-size: 3rem;
   margin-bottom: 1rem;
   text-align: center;
}

.salary-box p:first-child {
   margin-top: 0;
}

.salary-box p:last-child {
   margin-bottom: 0;
}


</style>
<body>
<?php

@include ('config.php');

if(isset($_POST['add_chef'])){
   $name = $_POST['name'];
   $salary = $_POST['salary'];
   if(empty($name) || empty($salary)){
      $message[] = 'please fill out details';
   }
   else{
         $check = mysqli_query($conn, "SELECT * FROM chef WHERE cname = '$name'");
         $cv = $check->num_rows;
         if($cv > 0){
            $message[] = '<b>This chef already works here!!<b>';
         }
      else{
         $insert = "INSERT INTO chef(cname, salary) VALUES('$name', '$salary')";
         $upload = mysqli_query($conn,$insert);
         if($upload){
            $message[] = 'welcome to the new chef';
         }else{
            $message[] = 'could not add this chef';
         }
      }
   }
};

if(isset($_GET['delete'])){
   $pk = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM chef WHERE cname = '$pk'");
   header('location:chef_add.php');
}; 
?>

<div class="container">
   <div class="admin-product-form-container">
      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
         <h3>Add a Chef</h3>
         <input type="text" placeholder="Full Name" name="name" class="box">
         <input type="number" placeholder="Salary" name="salary" class="box">
         <input type="submit" class="btn" name="add_chef" value="Add">
      </form>
   </div>

   <div class="salary-box">
   <h3>Salary Statistics</h3>
   <?php
   $result = mysqli_query($conn, "SELECT MIN(salary) AS min_salary, MAX(salary) AS max_salary, AVG(salary) AS avg_salary, SUM(salary) AS total_salary FROM chef");
   $stats = mysqli_fetch_assoc($result);
   if ($stats['min_salary'] !== null && $stats['max_salary'] !== null && $stats['avg_salary'] !== null && $stats['total_salary'] !== null) {
      echo "<p>Minimum Salary: ₹" . $stats['min_salary'] . "/-</p>";
      echo "<p>Maximum Salary: ₹" . $stats['max_salary'] . "/-</p>";
      echo "<p>Average Salary: ₹" . round($stats['avg_salary'], 2) . "/-</p>";
      echo "<p>Total Salary: ₹" . $stats['total_salary'] . "/-</p>";
   } else {
      echo "<p>No salary data available.</p>";
   }
   ?>
</div>


</div>


   <?php
   $select = mysqli_query($conn, "SELECT * FROM chef");
   ?>
   <div class="product-display">
      <table class="product-display-table">
         <thead>
            <tr>
               <th>Name</th>
               <th>Salary</th>
               <th>Action</th>
            </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><?php echo $row['cname']; ?></td>
            <td>₹<?php echo $row['salary']; ?>/-</td>
            <td>
               <a href="chef_update.php?edit=<?php echo $row['cname']; ?>" class="btn"> <i class="fas fa-edit"></i> update </a>
               <a href="chef_add.php?delete=<?php echo $row['cname']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
            </td>
         </tr>
      <?php } ?>
      </table>
   </div>
</div>
</body>
</html>
