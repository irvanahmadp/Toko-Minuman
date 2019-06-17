<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';
  if(strtoupper($_SESSION['level']) != 'A'){  /* Jika Orang Yang Login Bukan Admin */
    header("Location:".$base_url.'index.php');
  }else{

    $id_produk    = mysqli_real_escape_string($conn, $_GET['id_produk']);

    $produk_query = "SELECT nama, harga FROM tb_produk WHERE id_produk='$id_produk'";
    $produk_result= mysqli_query($conn, $produk_query);
    $result_arr   = mysqli_fetch_array($produk_result);

    if($_SERVER['REQUEST_METHOD'] == "POST"){
      $harga_jual = (int) filter_var($_POST['harga_jual'], FILTER_SANITIZE_NUMBER_INT);

      $tanggal    = date('Y-m-d H:i:s');
      $nama       = mysqli_real_escape_string($conn, $_POST['nama']);
      // Untuk produk, harga adalah harga jual
      $harga      = $harga_jual;

      $edit_produk_query = 
        "UPDATE tb_produk
          SET updated_at = '$tanggal',
            nama      = '$nama',
            harga     = '$harga_jual'
          WHERE id_produk = '$id_produk'
          LIMIT 1;    
          ";
      $edit_produk_result = mysqli_query($conn, $edit_produk_query) or die(mysqli_error());
      header("Location:".$base_url.'produk.php');
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Produk</title>
  <?php include 'layout/head.php'; ?>
</head>
<body class="app header-fixed sidebar-md-show sidebar-fixed">
  <header class="app-header navbar">
    <?php include 'layout/header.php'; ?>
  </header>
  <div class="app-body">
    <div class="sidebar">
      <?php include 'layout/sidebar.php'; ?>
    </div>
    <main class="main">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item "><a href="<?= $base_url; ?>produk.php">Produk</a></li>
          <li class="breadcrumb-item active">Edit Produk</li>
        </ol>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <i class="fa fa-edit"></i>Form Edit Produk
                <div class="card-header-actions">
                  <a class="btn-setting d-sm-down-none" href="#">
                    <i class="icon-settings"></i>
                  </a>
                  <a class="btn btn-minimize" href="#" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true">
                    <i class="icon-arrow-up"></i>
                  </a>
                  <a class="btn-close" href="#">
                    <i class="icon-close"></i>
                  </a>
                </div>
              </div>
              <div class="card-body collapse show" id="collapseExample" style="">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label class="col-form-label" for="prependedInput">Nama</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">@</span>
                        </div>
                        <input class="form-control" id="prependedInput" size="16" type="text" name="nama" required=""
                          value="<?= $result_arr['nama']; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="prependedInput">Harga Jual Satuan</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Rp</span>
                        </div>
                        <input class="form-control" id="prependedInput" onkeyup="FormatCurrency(this)" size="16" type="text" name="harga_jual" required=""
                        value="<?= number_format($result_arr['harga'], 0, '', '.'); ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-actions">
                    <button class="btn btn-primary" type="submit">Save changes</button>
                    <button class="btn btn-secondary" type="cancel">Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  <footer class="app-footer">
    <div>
      <a href="https://coreui.io">CoreUI</a>
      <span>&copy; 2018 creativeLabs.</span>
    </div>
    <div class="ml-auto">
      <span>Powered by</span>
      <a href="https://coreui.io">CoreUI</a>
    </div>
  </footer>
  <?php include 'layout/bottom.php'; ?>
  </body>
</html>