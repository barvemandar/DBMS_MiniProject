<?php

$conn = mysqli_connect('localhost:3308','root','','db');


if($conn){
    echo "connection established!";
}else{
    echo 'connection unsuccessful'.mysqli_connect_error();
}


?>