<?php
  session_start();
  $url = $_SERVER['REQUEST_URI'];
  $url_arr = explode('/', $url);
  if(!isset($_SESSION['nama']) || $_SESSION['nama'] == ''){
    /* Jika User Belum Login */
    //if($url_arr[2] != 'login.php' && $url_arr[2] != 'register.php' && $url_arr[2] != 'index.php'){
    if($url_arr[5] != 'login.php' && $url_arr[5] != 'register.php' && $url_arr[5] != 'index.php'){
      header("Location:".$base_url.'index.php');
    }
  }else{
    /* Jika User Sudah Login */
    //if($url_arr[2] == 'login.php' || $url_arr[2] == 'register.php' || $url_arr[2] == 'index.php' || $url_arr[2] == ''){
    if($url_arr[5] == 'login.php' || $url_arr[5] == 'register.php' || $url_arr[5] == 'index.php'){
      header("Location:".$base_url.'produk.php');
    }
  }
?>
