<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';

  $id_transaksi_jual = $_GET['id_transaksi'];

  $list_transaksi_query = 
    "SELECT tb_transaksi_jual_detail.*, tb_transaksi_jual.created_at, tb_transaksi_jual.nama AS nama_pembeli, tb_transaksi_jual.alamat AS alamat_pembeli, tb_produk.nama AS nama_produk
    FROM tb_transaksi_jual_detail
    INNER JOIN tb_transaksi_jual
      ON tb_transaksi_jual.id_transaksi_jual = tb_transaksi_jual_detail.id_transaksi_jual
    INNER JOIN tb_produk
      ON tb_transaksi_jual_detail.id_produk = tb_produk.id_produk
    WHERE tb_transaksi_jual.id_transaksi_jual = '$id_transaksi_jual'
    ";
    $list_transaksi_result= mysqli_query($conn, $list_transaksi_query) or die(mysqli_error($conn));
  
?>
<!DOCTYPE html>
<html>
<head>
  <title>Detail Transaksi</title>
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
          <li class="breadcrumb-item active">Detail Transaksi</li>
        </ol>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-xl-12 ">
            <div class="card">
              <div class="card-header">
                <i class="fa fa-align-justify"></i> Detail Transaksi</div>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                    <table class="table table-responsive-sm table-bordered table-striped datatable">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Minuman</th>
                          <?php if(strtoupper($_SESSION['level']) == 'A') { ?>
                            <th>Nama Pembeli</th>
                          <?php } ?>
                          <th>Alamat</th>
                          <th>Harga</th>
                          <th>Jumlah</th>
                          <th>Total Harga</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no = 1;
                          $total_jumlah = 0;
                          $total_harga_semua = 0;
                          while($transaksi = mysqli_fetch_array($list_transaksi_result, MYSQLI_ASSOC)){ ?>
                            <tr>
                            <td><?= $no; ?></td>
                            <td><?= $transaksi['created_at']; ?></td>
                            <td><?= $transaksi['nama_produk'] ?></td>
                            <?php if(strtoupper($_SESSION['level']) == 'A') { ?>
                              <td><?= $transaksi['nama_pembeli']; ?></td>
                            <?php } ?>
                            <td><?= $transaksi['alamat_pembeli']; ?></td>
                            <td>
                              Rp. <?= number_format($transaksi['harga'], 0, '', '.'); ?>
                            </td>
                            <td><?= $transaksi['jumlah']; ?></td>
                            <td>
                              Rp. <?= number_format($transaksi['total_harga'], 0, '', '.'); ?>
                            </td>
                            </tr>
                            
                        <?php 
                            $total_jumlah = $total_jumlah + $transaksi['jumlah'];
                            $total_harga_semua = $total_harga_semua + $transaksi['total_harga'];
                            $no++; 
                          } 
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th colspan="6">Total:</th>
                          <th><?= number_format($total_jumlah, 0, '', '.'); ?></th>
                          <th>Rp. <?= number_format($total_harga_semua, 0, '', '.'); ?></th>
                        </tr>
                      </tfoot>
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