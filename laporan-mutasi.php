<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';

  if(strtoupper($_SESSION['level']) != 'A'){
    header("Location:".$base_url.'index.php');
  }else{

    if($_SERVER['REQUEST_METHOD']=='POST'){
      $tgl_mulai    = $_POST['tgl_mulai'];
      $tgl_selesai  = $_POST['tgl_selesai'];
      $query_tgl_tj    = " WHERE date(tj.created_at) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
      $query_tgl_tb    = " WHERE date(tb.created_at) BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
    }else{
      $query_tgl_tj    = "";
      $query_tgl_tb    = "";
    }

    // $list_transaksi_query = 
    //   "SELECT t.tanggal, t.type, t.debit, t.credit, t.keterangan, p.nama AS nama_produk, b.nama AS nama_bahan
    //   FROM tb_transaksi t
    //     LEFT JOIN tb_produk p
    //       ON t.id_produk = p.id_produk
    //     LEFT JOIN tb_bahan b
    //       ON t.id_produk = b.id_bahan
    //   ".$query_tgl;
   $list_transaksi_query = 
      "SELECT *
        FROM
        (SELECT tj.created_at AS tanggal, 'produk' AS type, tj.harga, tj.jumlah, 'Penjualan Produk' AS keterangan, p.nama AS nama_produk, '' AS nama_bahan
          FROM tb_transaksi_jual tj
            LEFT JOIN tb_produk p
              ON tj.id_produk = p.id_produk
          $query_tgl_tj
        UNION ALL
        SELECT tb.created_at AS tanggal, 'bahan' AS type, tb.harga, tb.jumlah,'Pembelian Bahan' AS keterangan, '' AS nama_produk, tb.nama_bahan
          FROM tb_transaksi_beli tb
          $query_tgl_tb
        ) mutasi
        ORDER BY tanggal ASC";
    $list_transaksi_result= mysqli_query($conn, $list_transaksi_query);
  }
  
?>
<!DOCTYPE html>
<html>
<head>
  <title>Laporan Mutasi</title>
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
                <i class="fa fa-align-justify"></i> Laporan Mutasi</div>
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
                          <th>Type</th>
                          <th>Nama Produk/Bahan</th>
                          <th>Keterangan</th>
                          <th>Pengeluaran</th>
                          <th>Pemasukan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no = 1;
                          $total_pengeluaran = 0;
                          $total_pemasukan   = 0;
                          while($transaksi = mysqli_fetch_array($list_transaksi_result, MYSQLI_ASSOC)){ 
                            if($transaksi['type']=='produk'){
                              $pengeluaran  = 0;
                              $pemasukan    = $transaksi['harga'];
                            }else{
                              $pengeluaran  = $transaksi['harga'];
                              $pemasukan    = 0;
                            }
                          ?>
                            <tr>
                            <td><?= $no; ?></td>
                            <td><?= $transaksi['tanggal']; ?></td>
                            <td><?= ucfirst($transaksi['type']); ?></td>
                            <td><?= $transaksi['type'] == 'produk' 
                              ? $transaksi['nama_produk'] : $transaksi['nama_bahan']; ?></td>
                              <td><?= $transaksi['keterangan']; ?></td>
                            <td>Rp. <?= number_format($pengeluaran, 0, '', '.'); ?></td>
                            <td>Rp. <?= number_format($pemasukan, 0, '', '.'); ?></td>
                            </tr>
                            
                        <?php 
                            $no++;
                            $total_pengeluaran = $total_pengeluaran + $pengeluaran;
                            $total_pemasukan   = $total_pemasukan + $pemasukan;
                          } 
                        ?>
                      </tbody>
                      <tfoot>
                          <tr>
                              <th colspan="5">Total:</th>
                              <th>Rp. <?= number_format($total_pengeluaran, 0, '', '.'); ?></th>
                              <th>Rp. <?= number_format($total_pemasukan, 0, '', '.'); ?></th>
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