<?php
  $hostname_db = 'localhost';
  $username_db = 'root';
  $password_db = '';
  $database_db = 'toko_minuman';
  $conn = mysqli_connect($hostname_db, $username_db, $password_db, $database_db);
  // Check connection
  if(mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>
