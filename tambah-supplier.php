<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';
  if(strtoupper($_SESSION['level']) != 'A'){  /* Jika Orang Yang Login Bukan Admin */
    header("Location:".$base_url.'index.php');
  }else{
    if($_SERVER['REQUEST_METHOD'] == "POST"){

      $time       = time();
      $tanggal    = date('Y-m-d H:i:s');
      $nama       = mysqli_real_escape_string($conn, $_POST['nama']);
      $alamat     = mysqli_real_escape_string($conn, $_POST['alamat']);
      $telp     = mysqli_real_escape_string($conn, $_POST['telp']);

      $tambah_supplier_query = 
        "INSERT INTO tb_supplier (created_at, nama, alamat, telp)
          VALUES ('$tanggal', '$nama', '$alamat', '$telp')";
      $tambah_supplier_result = mysqli_query($conn, $tambah_supplier_query) or die(mysqli_error($conn));
      $id_supplier = mysqli_insert_id($conn);

      $add_supplier_msg = "Supplier berhasil ditambahkan";
      header( "Refresh:3; url=".$base_url."supplier.php", true, 303);
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Tambah Supplier</title>
  <?php include 'layout/head.php'; ?>
</head>
<body class="app header-fixed sidebar-md-show sidebar-fixed">
  <header class="app-header navbar">
    <?php include 'layout/header.php'; ?>
  </header>
  <div class="app-body">
    <div class="message-alert body">
      <?php if(isset($add_supplier_msg) && $add_supplier_msg != ''){ ?>
        <div class="alert alert-success">
          <center>
            <strong>
              <?= $add_supplier_msg; ?>
            </strong>
          </center>
        </div>
      <?php } ?>
    </div>
    <div class="sidebar">
      <?php include 'layout/sidebar.php'; ?>
    </div>
    <main class="main">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item "><a href="<?= $base_url; ?>supplier.php">Supplier</a></li>
          <li class="breadcrumb-item active">Tambah Supplier</li>
        </ol>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <i class="fa fa-edit"></i>Form Penambahan Supplier
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
                    <label class="col-form-label" for="prependedInput">Nama Supplier</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">@</span>
                        </div>
                        <input class="form-control" id="prependedInput" size="16" type="text" name="nama" required="">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="prependedInput">Alamat Supplier</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <textarea name="alamat" class="form-control" required=""></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="prependedInput">Nomer Telpon</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <input name="telp" class="form-control" required="">
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