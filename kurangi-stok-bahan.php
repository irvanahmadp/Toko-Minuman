<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';
  if(strtoupper($_SESSION['level']) != 'A'){  /* Jika Orang Yang Login Bukan Admin */
    header("Location:".$base_url.'index.php');
  }else{

    $id_bahan    = mysqli_real_escape_string($conn, $_GET['id_bahan']);

    $bahan_query = "SELECT nama FROM tb_bahan WHERE id_bahan='$id_bahan'";
    $bahan_result= mysqli_query($conn, $bahan_query);
    $result_arr   = mysqli_fetch_array($bahan_result);

    if($_SERVER['REQUEST_METHOD'] == "POST"){
      $harga = (int) filter_var($_POST['harga'], FILTER_SANITIZE_NUMBER_INT);

      $tanggal    = date('Y-m-d H:i:s');
      $stok       = (int) filter_var($_POST['stok'], FILTER_SANITIZE_NUMBER_INT);

      $kurangi_stok_query = 
        "UPDATE tb_bahan
          SET updated_at = '$tanggal',
            stok      = stok - $stok
          WHERE id_bahan = '$id_bahan'
          LIMIT 1;    
          ";
      $kurangi_stok_result = mysqli_query($conn, $kurangi_stok_query) or die(mysqli_error());
      header("Location:".$base_url.'bahan.php');
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Kurangi Stok</title>
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
          <li class="breadcrumb-item "><a href="<?= $base_url; ?>bahan.php">Bahan</a></li>
          <li class="breadcrumb-item active">Kurangi Stok</li>
        </ol>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <i class="fa fa-edit"></i>Form Pengurangan Stok
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
                        <input class="form-control" id="prependedInput" size="16" type="text" name="nama" required=""  readonly=""
                          value="<?= $result_arr['nama']; ?>"/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="prependedInput">Pengurangan Stok</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Jml</span>
                        </div>
                        <input class="form-control" id="prependedInput" size="16" type="number" name="stok" value="0" required="">
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
  </footer>
  <?php include 'layout/bottom.php'; ?>
  </body>
</html>