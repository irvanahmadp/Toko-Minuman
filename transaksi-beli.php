<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';
  if(strtoupper($_SESSION['level']) != 'A'){  /* Jika Orang Yang Login Bukan Admin */
    header("Location:".$base_url.'index.php');
  }else{
    if($_SERVER['REQUEST_METHOD'] == "POST"){
      $harga = (int) filter_var($_POST['harga'], FILTER_SANITIZE_NUMBER_INT);

      $time       = time();
      $tanggal    = date('Y-m-d H:i:s');
      $nama       = mysqli_real_escape_string($conn, $_POST['nama']);

      $id_supplier          = mysqli_real_escape_string($conn, $_POST['id_supplier']);
      $data_supplier_query  = "SELECT * FROM tb_supplier WHERE id_supplier = '$id_supplier' LIMIT 1";
      $data_supplier_result = mysqli_query($conn, $data_supplier_query);
      $data_supplier        = mysqli_fetch_array($data_supplier_result, MYSQLI_ASSOC);

      $nama_supplier  = $data_supplier['nama'];
      $alamat_supplier= $data_supplier['alamat'];

      $jumlah     = (int) filter_var($_POST['jumlah'], FILTER_SANITIZE_NUMBER_INT);
      $satuan     = mysqli_real_escape_string($conn, $_POST['satuan']);

      // $tambah_bahan_query = 
      //   "INSERT INTO tb_bahan (created_at,  nama, id_supplier, jumlah, satuan, harga)
      //     VALUES ('$tanggal', '$nama', '$id_supplier', '$jumlah', '$satuan', '$harga')";
      // $tambah_bahan_result = mysqli_query($conn, $tambah_bahan_query) or die(mysqli_error($conn));
      // $id_bahan = mysqli_insert_id($conn);

      $id_user  = $_SESSION['id_user'];
      /*$transaksi_tambah_bahan_query =
        "INSERT INTO tb_transaksi (tanggal_key, tanggal, id_user, type, id_produk, jumlah, debit, credit, keterangan, nama, alamat)
          VALUES ('$time', '$tanggal', '$id_user', '$type', '$id_bahan', '$jumlah', '$harga', 0, '$keterangan', '$nama_supplier', '$alamat_supplier')";
      $transaksi_tambah_bahan_result = mysqli_query($conn, $transaksi_tambah_bahan_query) or 
        die(mysqli_error($conn));*/

      $transaksi_tambah_bahan_query =
        "INSERT INTO tb_transaksi_beli (created_at, nama_bahan, jumlah, satuan, harga, id_supplier)
          VALUES ('$tanggal', '$nama', '$jumlah', '$satuan', '$harga', '$id_supplier')";
      $transaksi_tambah_bahan_result = mysqli_query($conn, $transaksi_tambah_bahan_query) or 
        die(mysqli_error($conn));

      $add_bahan_msg = "Bahan berhasil ditambahkan";
      header( "Refresh:3; url=".$base_url."laporan-mutasi.php", true, 303);
    }

    /* List Semua Supplier */
    $list_supplier_query = "SELECT * FROM tb_supplier";
    $list_supplier_result= mysqli_query($conn, $list_supplier_query);

    $data_supplier_arr = array();
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Transaksi Beli</title>
  <?php include 'layout/head.php'; ?>
</head>
<body class="app header-fixed sidebar-md-show sidebar-fixed">
  <header class="app-header navbar">
    <?php include 'layout/header.php'; ?>
  </header>
  <div class="app-body">
    <div class="message-alert body">
      <?php if(isset($add_bahan_msg) && $add_bahan_msg != ''){ ?>
        <div class="alert alert-success">
          <center>
            <strong>
              <?= $add_bahan_msg; ?>
            </strong>
          </center>
        </div>
      <?php } ?>
    </div>
    <div class="sidebar">
      <?php include 'layout/sidebar.php'; ?>
    </div>
    <main class="main">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item "><a href="<?= $base_url; ?>bahan.php">Bahan</a></li>
          <li class="breadcrumb-item active">Tambah Bahan</li>
        </ol>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <i class="fa fa-edit"></i>Form Penambahan Bahan
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
                        <input class="form-control" id="prependedInput" size="16" type="text" name="nama" required="">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="prependedInput">Jumlah</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Jml</span>
                        </div>
                        <input class="form-control" id="prependedInput" size="16" type="number" name="jumlah"  required="">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="prependedInput">Satuan</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Stn</span>
                        </div>
                        <input class="form-control" id="prependedInput" size="16" type="text" name="satuan"  required="">
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
                        <input class="form-control" id="prependedInput" onkeyup="FormatCurrency(this)" size="16" type="text" name="harga" required="">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="prependedInput">Nama Supplier</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">@</span>
                        </div>
                        <select name="id_supplier" required="" class="form-control select2 nama-supplier-select">
                          <option disabled selected value="">Supplier</option>
                          <?php
                            while($supplier = mysqli_fetch_array($list_supplier_result, MYSQLI_ASSOC)){
                              echo "<option value = \"$supplier[id_supplier]\">$supplier[nama]</option>";
                              $data_supplier_arr[$supplier['id_supplier']] = $supplier['alamat'];
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group alamat-supplier-wrapper" style="display: none">
                    <label class="col-form-label" for="prependedInput">Alamat Supplier</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <textarea name="alamat_supplier" class="form-control" readonly=""></textarea>
                      </div>
                    </div>
                  </div>
                  <!--  Data Supplier Diambil Dari DB
                  <div class="form-group">
                    <label class="col-form-label" for="prependedInput">Nama Supplier</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">@</span>
                        </div>
                        <input class="form-control" id="prependedInput" size="16" type="text" name="nama_supplier" required="">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="prependedInput">Alamat Supplier</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <textarea name="alamat_supplier" class="form-control"></textarea>
                      </div>
                    </div>
                  </div>
                  -->
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
  <script type="text/javascript">
    var data_supplier = <?= json_encode($data_supplier_arr); ?>;
  </script>
  <?php include 'layout/bottom.php'; ?>
  </body>
</html>