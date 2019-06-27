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
      $tanggal    = date('Y-m-d H:i:s');
      $stok       = (int) filter_var($_POST['stok'], FILTER_SANITIZE_NUMBER_INT);

      $tambah_stok_query = 
        "UPDATE tb_produk
          SET updated_at = '$tanggal',
            stok      = stok + $stok
          WHERE id_produk = '$id_produk'
          LIMIT 1;    
          ";
      $tambah_stok_result = mysqli_query($conn, $tambah_stok_query) or die(mysqli_error());


      $produk_bahan_query = 
      "SELECT * FROM tb_bahan_produk WHERE id_produk = '$id_produk'";
      $produk_bahan_result = mysqli_query($conn, $produk_bahan_query);
      while($produk_bahan_arr = mysqli_fetch_array($produk_bahan_result, MYSQLI_ASSOC)){
        $id_bahan = $produk_bahan_arr['id_bahan'];
        $jumlah_bahan_satuan_produk = $produk_bahan_arr['jumlah'];
        $jumlah_bahan = $jumlah_bahan_satuan_produk * $stok;
        $id_bahan_produk = $produk_bahan_arr['id_bahan_produk'];

        // $tambah_bahan_produk_query = 
        //   "INSERT INTO tb_bahan_produk (created_at, jumlah, id_produk, id_bahan)
        //     VALUES ('$tanggal', '$jumlah_bahan_satuan_produk', '$id_produk', $id_bahan)";
        // $tambah_bahan_produk_result = mysqli_query($conn, $tambah_bahan_produk_query);
        // $id_bahan_produk = mysqli_insert_id($conn);

        $data_satuan_bahan_query = "
          SELECT satuan FROM tb_bahan WHERE id_bahan = '$id_bahan';
        ";
        $data_satuan_bahan_result = mysqli_query($conn, $data_satuan_bahan_query);
        $data_satuan_bahan_arr    = mysqli_fetch_array($data_satuan_bahan_result, MYSQLI_ASSOC);
        $satuan                   = $data_satuan_bahan_arr['satuan'];

        $penggunaan_bahan_query =
          "INSERT INTO tb_penggunaan_bahan (created_at, id_bahan, id_bahan_produk, jumlah, satuan, keterangan)
            VALUES ('$tanggal', '$id_bahan', '$id_bahan_produk', '$jumlah_bahan', '$satuan', 'Untuk $result_arr[nama]')
          ";
        $penggunaan_bahan_result = mysqli_query($conn, $penggunaan_bahan_query);

        $update_stok_bahan_query = 
          "UPDATE tb_bahan SET stok = stok - $jumlah_bahan WHERE id_bahan = '$id_bahan' LIMIT 1";
        $update_stok_bahan_result = mysqli_query($conn, $update_stok_bahan_query);
      }

      //header("Location:".$base_url.'produk.php');
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Tambah Stok</title>
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
          <li class="breadcrumb-item active">Tambah Stok</li>
        </ol>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <i class="fa fa-edit"></i>Form Tambah Stok
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
                        <input class="form-control" id="prependedInput" size="16" type="text" name="nama" required="" readonly=""
                          value="<?= $result_arr['nama']; ?>"/>
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
                        <input class="form-control" id="prependedInput" onkeyup="FormatCurrency(this)" size="16" type="text" name="harga_jual" required="" readonly=""
                        value="<?= number_format($result_arr['harga'], 0, '', '.'); ?>"/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="prependedInput">Penambahan Stok</label>
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