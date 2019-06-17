<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';

  $id_produk    = mysqli_real_escape_string($conn, $_GET['id_produk']);

  $produk_query = "SELECT nama, harga, stok FROM tb_produk WHERE id_produk='$id_produk'";
  $produk_result= mysqli_query($conn, $produk_query);
  $result_arr   = mysqli_fetch_array($produk_result);

  if($_SESSION['level']=='A'){
    $title = 'Penjualan Minuman';
  }else{
    $title = 'Pembelian Minuman';
  }

  if($_SERVER['REQUEST_METHOD']=='POST'){

    $tanggal  = date("Y-m-d H:i:s");
    $id_user  = $_SESSION['id_user'];
    $id_produk= $id_produk;
    $jumlah   = $_POST['jumlah'];
    $harga_jual= (int) filter_var($_POST['harga_jual'], FILTER_SANITIZE_NUMBER_INT);;
    $harga    = $harga_jual;
    if(strtoupper($_SESSION['level'])=='A'){
      $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    }else{
      $nama   = $_SESSION['nama'];
    }
    $alamat   = mysqli_real_escape_string($conn, $_POST['alamat_pembeli']);

    $transaksi_penjualan_query =
      "INSERT INTO tb_transaksi_jual (created_at, id_produk, jumlah, harga, id_user, alamat)
        VALUES ('$tanggal', '$id_produk', '$jumlah', '$harga','$id_user', '$alamat')";
    $transaksi_tambah_penjualan_query = mysqli_query($conn, $transaksi_penjualan_query) or 
      die(mysqli_error($conn));

    $update_stok_query =
      "UPDATE tb_produk
        SET stok = stok - $jumlah,
          updated_at = '$tanggal'
      WHERE id_produk = '$id_produk'
      LIMIT 1";
    $update_stok_result = mysqli_query($conn, $update_stok_query) or 
      die(mysqli_error($conn));

    header("Location:".$base_url.'produk.php');
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title><?= $title; ?></title>
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
          <li class="breadcrumb-item "><a href="<?= $base_url; ?>">Home</a></li>
          <li class="breadcrumb-item active">Transaksi</li>
        </ol>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <i class="fas fa-shopping-cart"></i> Form <?= $title; ?>
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
                    <label class="col-form-label" for="prependedInput">Produk</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-coffee"></i>
                          </span>
                        </div>
                        <input class="form-control" id="prependedInput" size="16" type="text" name="nama"
                          value="<?= $result_arr['nama']; ?>" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="prependedInput">Harga</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Rp</span>
                        </div>
                        <input class="form-control" id="prependedInput" onkeyup="FormatCurrency(this)" size="16" type="text" name="harga_jual" readonly=""
                        value="<?= number_format($result_arr['harga'], 0, '', '.'); ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="prependedInput">Jumlah</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fas fa-cart-plus"></i>
                          </span>
                        </div>
                        <input class="form-control js-jumlah-produk"
                          id="prependedInput"
                          size="16"
                          type="number"
                          name="jumlah"  
                          value="1" 
                          min="1"
                          max="<?= $result_arr['stok']; ?>"/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="prependedInput">Total Harga</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Rp</span>
                        </div>
                        <input 
                          class="form-control" id="prependedInput" onkeyup="FormatCurrency(this)" size="16" type="text" name="total_harga" readonly=""
                          value="<?= number_format($result_arr['harga'], 0, '', '.'); ?>"/>
                      </div>
                    </div>
                  </div>
                  <?php if(strtoupper($_SESSION['level']) == 'A'){ ?>
                    <div class="form-group">
                      <label class="col-form-label" for="prependedInput">Nama Pembeli</label>
                      <div class="controls">
                        <div class="input-prepend input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fas fa-user"></i>
                            </span>
                          </div>
                          <input 
                            class="form-control" id="prependedInput" size="16" type="text" name="nama" required="" />
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-form-label" for="prependedInput">Alamat Pembeli (optional)</label>
                      <div class="controls">
                        <div class="input-prepend input-group">
                          <textarea name="alamat_pembeli" class="form-control"></textarea>
                        </div>
                      </div>
                    </div>
                  <?php } else{ ?>
                    <div class="form-group">
                      <label class="col-form-label" for="prependedInput">Alamat</label>
                      <div class="controls">
                        <div class="input-prepend input-group">
                          <textarea name="alamat_pembeli" class="form-control" required=""></textarea>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                  <div class="form-actions">
                    <button class="btn btn-primary" type="submit">Save changes</button>
                    <button class="btn btn-secondary" type="cancel">Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div><!-- end .row -->
      </div><!-- end .container-fluid -->
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