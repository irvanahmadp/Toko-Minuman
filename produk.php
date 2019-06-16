<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';

  if($_SESSION['level']=='A'){
    $list_produk_query = "SELECT * FROM tb_produk";
  }else{
    $list_produk_query = "SELECT * FROM tb_produk WHERE stok > 0";
  }
  
  $list_produk_result= mysqli_query($conn, $list_produk_query);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Toko Minuman</title>
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
          <li class="breadcrumb-item active">Produk</li>
        </ol>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-xl-12 ">
            <div class="card">
              <div class="card-header">
                <i class="fa fa-align-justify"></i> Daftar Minuman</div>
              <div class="card-body">
                <div class="row">
                  <?php if(strtoupper($_SESSION['level'])=='A') { ?>
                    <div class="col-lg-12" style="margin-bottom: 25px;">
                      <a class="btn btn-primary"
                        href="<?= $base_url; ?>tambah-produk.php"
                        role="button"
                        style="float: right;">
                        Tambah Produk
                      </a>
                    </div>
                  <?php } ?>
                  <div class="col-lg-12">
                    <table class="table table-responsive-sm table-bordered table-striped datatable">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Minuman</th>
                          <th>Harga</th>
                          <th>Stok</th>
                          <th>Gambar</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no = 1;
                          while($produk = mysqli_fetch_array($list_produk_result, MYSQLI_ASSOC)){ ?>
                            <tr>
                            <td><?= $no ?></td>
                            <td><?= $produk['tanggal']; ?> </td>
                            <td><?= $produk['nama']; ?> </td>
                            <td>Rp. <?= number_format($produk['harga'], 0,"","."); ?> </td>
                            <td><?= $produk['stok'] == 0 ? 'Habis' : $produk['stok']; ?> </td>
                            <td>
                              <center>
                                <img 
                                  src="<?= $base_url.'images/'.$produk['img']; ?>" alt="<?= $produk['nama']; ?>"
                                  class="img-thumbnail img-responsive"
                                  style="max-height: 100px; max-width: 100px">
                              </center>
                            </td>
                            <td>
                              <?php if(strtoupper($_SESSION['level']) == 'A') { ?>
                                <a class="btn btn-primary btn-block"
                                  href="<?= $base_url; ?>transaksi.php?id_produk=<?= $produk['id_produk']; ?>">Jual
                                </a>
                                <a class="btn btn-warning btn-block"
                                  href="<?= $base_url; ?>edit-produk.php?id_produk=<?= $produk['id_produk']; ?>">
                                  Edit
                                </a>
                                <a class="btn btn-success btn-block"
                                  href="<?= $base_url; ?>tambah-stok-produk.php?id_produk=<?= $produk['id_produk']; ?>">
                                  Tambah Stok
                                </a>
                              <?php } else{ ?>
                                <a class="btn btn-primary btn-block"
                                  href="<?= $base_url; ?>transaksi.php?id_produk=<?= $produk['id_produk']; ?>">Beli
                                </a>
                              <?php } ?>
                            </td>
                            </tr>
                            
                        <?php 
                            $no++; 
                          } 
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
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