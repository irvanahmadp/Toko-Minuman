<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';

  if($_SERVER['REQUEST_METHOD']=='POST'){
    $tgl_mulai    = $_POST['tgl_mulai'];
    $tgl_selesai  = $_POST['tgl_selesai'];
    if(strtoupper($_SESSION['level']) == 'A'){
      /* Jika user admin maka where hanya tanggal */
      $query_tgl    = " WHERE date(t.created_at) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
    }else{
      /* Jika user selain admin maka where id_user dan tanggal */
      $query_tgl    = " AND date(t.created_at) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
    }
  }else{
    $query_tgl    = "";
  }

  if(strtoupper($_SESSION['level']) == 'A'){  
    /* Jika Yang Login Admin */
    // $list_transaksi_query = 
    //   "SELECT t.tanggal, t.credit, t.jumlah, t.nama as nama_pembeli, t.alamat as alamat_pembeli, p.nama as minuman
    //   FROM tb_transaksi t
    //     INNER JOIN tb_produk p
    //       ON t.id_produk = p.id_produk
    //   WHERE type = 'produk'".$query_tgl;
    $list_transaksi_query = 
      "SELECT t.created_at, t.harga, t.jumlah, t.nama as nama_pembeli, t.alamat as alamat_pembeli, p.nama as minuman
      FROM tb_transaksi_jual t
        INNER JOIN tb_produk p
          ON t.id_produk = p.id_produk
      ".$query_tgl;
    $list_transaksi_result= mysqli_query($conn, $list_transaksi_query);
  }else{
    /* Jika Yang Login Bukan Admin */
    // $list_transaksi_query = 
    //   "SELECT t.tanggal, t.credit, t.jumlah, t.nama as nama_pembeli, t.alamat as alamat_pembeli, p.nama as minuman
    //   FROM tb_transaksi t
    //     INNER JOIN tb_produk p
    //       ON t.id_produk = p.id_produk
    //   WHERE type = 'produk'
    //     AND id_user = '$_SESSION[id_user]'".$query_tgl;
    $list_transaksi_query = 
      "SELECT t.created_at, t.harga, t.jumlah, t.nama as nama_pembeli, t.alamat as alamat_pembeli, p.nama as minuman
      FROM tb_transaksi_jual t
        INNER JOIN tb_produk p
          ON t.id_produk = p.id_produk
      WHERE id_user = '$_SESSION[id_user]'".$query_tgl;
    $list_transaksi_result= mysqli_query($conn, $list_transaksi_query);
  }

  
?>
<!DOCTYPE html>
<html>
<head>
  <title>Laporan Transaksi</title>
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
          <li class="breadcrumb-item active">Laporan Transaksi</li>
        </ol>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-xl-12 ">
            <div class="card">
              <div class="card-header">
                <i class="fa fa-align-justify"></i> Laporan Transaksi</div>
              <div class="card-body">
                <form style="margin-bottom: 25px" method="POST">
                  <div class="form-row">
                    <div class="col-2">
                      <input type="text" class="form-control datepicker" placeholder="Dari Tanggal" name="tgl_mulai" required="">
                    </div>
                    <div class="col-2">
                      <input type="text" class="form-control datepicker" placeholder="Sampai Tanggal" name="tgl_selesai" required="">
                    </div>
                    <div class="col-3">
                      <button class="btn btn-primary">Lihat</button>
                    </div>
                  </div>
                </form>
                <div class="row">
                  <div class="col-lg-12">
                    <table class="table table-responsive-sm table-bordered table-striped datatable">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Minuman</th>
                          <th>Harga</th>
                          <th>Jumlah</th>
                          <th>Total Harga</th>
                          <?php if(strtoupper($_SESSION['level']) == 'A') { ?>
                            <th>Nama Pembeli</th>
                          <?php } ?>
                          <th>Alamat</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no = 1;
                          while($transaksi = mysqli_fetch_array($list_transaksi_result, MYSQLI_ASSOC)){ ?>
                            <tr>
                            <td><?= $no; ?></td>
                            <td><?= $transaksi['created_at']; ?></td>
                            <td><?= $transaksi['minuman']; ?></td>
                            <td>
                              Rp. <?= number_format($transaksi['harga'] / $transaksi['jumlah'], 0, '', '.'); ?>
                            </td>
                            <td><?= $transaksi['jumlah']; ?></td>
                            <td>
                              Rp. <?= number_format($transaksi['harga'], 0, '', '.'); ?>
                            </td>
                            <?php if(strtoupper($_SESSION['level']) == 'A') { ?>
                              <td><?= $transaksi['nama_pembeli']; ?></td>
                            <?php } ?>
                            <td><?= $transaksi['alamat_pembeli']; ?></td>
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