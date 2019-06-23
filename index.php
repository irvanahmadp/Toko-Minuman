<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Toko Minuman</title>
  <?php include 'layout/head.php'; ?>
</head>
<body class="app header-fixed sidebar-md-show">
  <header class="app-header navbar">
    <?php include 'layout/header.php'; ?>
  </header>
  <div class="app-body">
    <main class="main">
      <div class="container" style="margin-top: 50px; margin-bottom: 50px">
        <div class="card">
          <div class="card-body">
            <div class="row justify-content-center image-galery align-items-center">
              <div class="col-3">
                <div class="img-thumbnail">
                  <img src="assets/img/img-1.jpeg" alt="Image 1" class="img-fluid rounded mx-auto">
                </div>
              </div>
              <div class="col-3">
                <div class="img-thumbnail">
                  <img src="assets/img/img-2.jpeg" alt="Image 2" class="img-fluid rounded mx-auto">
                </div>
              </div>
              <div class="col-3">
                <div class="img-thumbnail">
                  <img src="assets/img/img-3.jpeg" alt="Image 3" class="img-fluid rounded mx-auto">
                </div>
              </div>
            </div>
            <div class="row justify-content-md-center image-galery">
              <div class="col-3">
                <div class="img-thumbnail">
                  <img src="assets/img/img-1.jpeg" alt="Image 1" class="img-fluid rounded mx-auto">
                </div>
              </div>
              <div class="col-3">
                <div class="img-thumbnail">
                  <img src="assets/img/img-2.jpeg" alt="Image 2" class="img-fluid rounded mx-auto">
                </div>
              </div>
              <div class="col-3">
                <div class="img-thumbnail">
                  <img src="assets/img/img-3.jpeg" alt="Image 3" class="img-fluid rounded mx-auto">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  <?php include 'layout/bottom.php'; ?>
  </body>
</html>