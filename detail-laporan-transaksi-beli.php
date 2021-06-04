<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';

  if(strtoupper($_SESSION['level']) != 'A'){
    /* Jika Orang Yang Login Bukan Admin */
    header("Location:".$base_url.'index.php');
  }

  $id_transaksi_beli = $_GET['id_transaksi'];

  $list_bahan_query =
    "SELECT tb_transaksi_beli_detail.*, tb_transaksi_beli.created_at ,supplier.nama AS nama_supplier, supplier.alamat AS alamat_supplier, tb_bahan.nama AS nama_bahan
    FROM tb_transaksi_beli_detail
    INNER JOIN tb_transaksi_beli
      ON tb_transaksi_beli_detail.id_transaksi_beli = tb_transaksi_beli.id_transaksi_beli
    INNER JOIN tb_supplier supplier
      ON tb_transaksi_beli.id_supplier = supplier.id_supplier
    INNER JOIN tb_bahan
      ON tb_transaksi_beli_detail.id_bahan = tb_bahan.id_bahan
    WHERE tb_transaksi_beli.id_transaksi_beli = '$id_transaksi_beli'
    ";
  $list_bahan_result= mysqli_query($conn, $list_bahan_query);
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
                <div class="col-lg-12">
                  <table class="table table-responsive-sm table-bordered table-striped datatable">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Bahan</th>
                        <th>Supplier</th>
                        <th>Alamat Supplier</th>
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
                        while($bahan = mysqli_fetch_array($list_bahan_result, MYSQLI_ASSOC)){ ?>
                          <tr>
                          <td><?= $no ?></td>
                          <td><?= $bahan['created_at']; ?> </td>
                          <td><?= $bahan['nama_bahan']; ?></td>
                          <td><?= $bahan['nama_supplier']; ?></td>
                          <td><?= $bahan['alamat_supplier']; ?></td>
                          <td>Rp. <?= number_format($bahan['harga'], 0, '', '.'); ?></td>
                          <td><?= $bahan['jumlah']; ?></td>
                          <td>Rp. <?= number_format($bahan['total_harga'], 0, '', '.'); ?></td>
                          </tr>

                      <?php
                          $total_jumlah = $total_jumlah + $bahan['jumlah'];
                          $total_harga_semua = $total_harga_semua + $bahan['total_harga'];
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
        </div><!-- end .row -->
      </div><!-- end .container-fluid -->
    </main>
  </div>
  <footer class="app-footer">
  </footer>
  <?php include 'layout/bottom.php'; ?>
  </body>
</html>