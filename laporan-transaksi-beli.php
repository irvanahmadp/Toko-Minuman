<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';

  if(strtoupper($_SESSION['level']) != 'A'){  
    /* Jika Orang Yang Login Bukan Admin */
    header("Location:".$base_url.'index.php');
  }
  $tgl_mulai    = '';
  $tgl_selesai  = '';
  if($_SERVER['REQUEST_METHOD']=='POST'){
    $tgl_mulai    = $_POST['tgl_mulai'];
    $tgl_selesai  = $_POST['tgl_selesai'];
    if(strtoupper($_SESSION['level']) == 'A'){
      /* Jika user admin maka where hanya tanggal */
      $query_tgl    = " WHERE date(tb_transaksi_beli.created_at) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
    }else{
      /* Jika user selain admin maka where id_user dan tanggal */
      $query_tgl    = " AND date(tb_transaksi_beli.created_at) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
    }
  }else{
    $query_tgl    = "";
  }

  $list_bahan_query = 
    "SELECT tb_transaksi_beli_detail.*, tb_transaksi_beli.created_at, tb_bahan.nama AS nama_bahan, supplier.nama AS nama_supplier, supplier.alamat AS alamat_supplier FROM tb_transaksi_beli_detail
    INNER JOIN tb_bahan
      ON tb_transaksi_beli_detail.id_bahan = tb_bahan.id_bahan
    INNER JOIN tb_transaksi_beli
      ON tb_transaksi_beli_detail.id_transaksi_beli = tb_transaksi_beli.id_transaksi_beli
    INNER JOIN tb_supplier supplier
      ON tb_transaksi_beli.id_supplier = supplier.id_supplier ".
    $query_tgl;
  $list_bahan_result= mysqli_query($conn, $list_bahan_query);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Laporan Transaksi Beli</title>
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
                <form style="margin-bottom: 25px" method="POST">
                  <div class="form-row">
                    <div class="col-2">
                      <input type="text" class="form-control datepicker" placeholder="Dari Tanggal" name="tgl_mulai" required="" value="<?= $tgl_mulai; ?>">
                    </div>
                    <div class="col-2">
                      <input type="text" class="form-control datepicker" placeholder="Sampai Tanggal" name="tgl_selesai" required="" value="<?= $tgl_selesai; ?>">
                    </div>
                    <div class="col-3">
                      <button class="btn btn-primary">Lihat</button>
                    </div>
                  </div>
                </form>
                <div class="col-lg-12">
                  <table class="table table-responsive-sm table-bordered table-striped datatable">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Bahan</th>
                        <th>Nama Supplier</th>
                        <th>Alamat Supplier</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $no = 1;
                        while($bahan = mysqli_fetch_array($list_bahan_result, MYSQLI_ASSOC)){ ?>
                          <tr>
                          <td><?= $no ?></td>
                          <td><?= $bahan['created_at']; ?> </td>
                          <td><?= $bahan['nama_bahan']; ?> </td>
                          <td><?= $bahan['nama_supplier']; ?></td>
                          <td><?= $bahan['alamat_supplier']; ?></td>
                          <td><?= number_format($bahan['harga'], 0, '', '.'); ?></td>
                          <td><?= $bahan['jumlah'].' '.$bahan['satuan']; ?> </td>
                          <td><?= number_format($bahan['total_harga'], 0, '', '.'); ?></td>
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
        </div><!-- end .row -->
      </div><!-- end .container-fluid -->
    </main>
  </div>
  <footer class="app-footer">
  </footer>
  <?php include 'layout/bottom.php'; ?>
  </body>
</html>