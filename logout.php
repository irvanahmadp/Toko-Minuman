<?php
  session_start();
  session_destroy();
  include 'config/url.php';
  header("Location:".$base_url.'login.php');
?>