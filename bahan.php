<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';

  if(strtoupper($_SESSION['level']) != 'A'){  
    /* Jika Orang Yang Login Bukan Admin */
    header("Location:".$base_url.'index.php');
  }

  $list_bahan_query = 
    "SELECT tb_transaksi_beli.*, supplier.nama AS nama_supplier, supplier.alamat AS alamat_supplier FROM tb_transaksi_beli
    INNER JOIN tb_supplier supplier
      ON tb_transaksi_beli.id_supplier = supplier.id_supplier";
  $list_bahan_result= mysqli_query($conn, $list_bahan_query);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Bahan</title>
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
          <li class="breadcrumb-item active">Bahan</li>
        </ol>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-xl-12 ">
            <div class="card">
              <div class="card-header">
                <i class="fa fa-align-justify"></i> Daftar Pembelian Bahan</div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12" style="margin-bottom: 25px;">
                    <a class="btn btn-primary"
                      href="<?= $base_url; ?>tambah-bahan.php"
                      role="button"
                      style="float: right;">
                      Tambah Bahan
                    </a>
                  </div>
                  <div class="col-lg-12">
                    <table class="table table-responsive-sm table-bordered table-striped datatable">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Bahan</th>
                          <th>Nama Supplier</th>
                          <th>Alamat Supplier</th>
                          <th>Jumlah</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no = 1;
                          while($bahan = mysqli_fetch_array($list_bahan_result, MYSQLI_ASSOC)){ ?>
                            <tr>
                            <td><?= $no ?></td>
                            <td><?= $bahan['nama_bahan']; ?> </td>
                            <td><?= $bahan['nama_supplier']; ?></td>
                            <td><?= $bahan['alamat_supplier']; ?></td>
                            <td><?= $bahan['jumlah'].' '.$bahan['satuan']; ?> </td>
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
  </footer>
  <?php include 'layout/bottom.php'; ?>
  </body>
</html>