<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';

  if(strtoupper($_SESSION['level']) != 'A'){  
    /* Jika Orang Yang Login Bukan Admin */
    header("Location:".$base_url.'index.php');
  }

  $list_bahan_query = 
    "SELECT tb_penggunaan_bahan.*, tb_bahan.nama
     FROM tb_penggunaan_bahan
      INNER JOIN tb_bahan
        ON tb_penggunaan_bahan.id_bahan = tb_bahan.id_bahan
          ";
  $list_bahan_result= mysqli_query($conn, $list_bahan_query);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Daftar Pengurangan Stok Bahan</title>
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
          <li class="breadcrumb-item active">Daftar Pengurangan Stok Bahan</li>
        </ol>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-xl-12 ">
            <div class="card">
              <div class="card-header">
                <i class="fa fa-align-justify"></i> Daftar Pengurangan Stok Bahan</div>
              <div class="card-body">
                  <div class="col-lg-12">
                    <table class="table table-responsive-sm table-bordered table-striped datatable">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tanggal</th>
                          <th>Bahan</th>
                          <th>Jumlah</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no = 1;
                          while($bahan = mysqli_fetch_array($list_bahan_result, MYSQLI_ASSOC)){ ?>
                            <tr>
                            <td><?= $no ?></td>
                            <td><?= $bahan['created_at']; ?> </td>
                            <td><?= $bahan['nama']; ?> </td>
                            <td><?= $bahan['jumlah'].' '.$bahan['satuan']; ?> </td>
                            <td><?= $bahan['keterangan']; ?> </td>
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