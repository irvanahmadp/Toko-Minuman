<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';
  if(strtoupper($_SESSION['level']) != 'A'){  /* Jika Orang Yang Login Bukan Admin */
    header("Location:".$base_url.'index.php');
  }else{
    if($_SERVER['REQUEST_METHOD'] == "POST"){
      $time       = time();
      $tanggal    = date('Y-m-d H:i:s');
      $jumlah_transaksi = $_POST['jumlah_transaksi'];

      $id_supplier          = mysqli_real_escape_string($conn, $_POST['id_supplier']);
      $data_supplier_query  = "SELECT * FROM tb_supplier WHERE id_supplier = '$id_supplier' LIMIT 1";
      $data_supplier_result = mysqli_query($conn, $data_supplier_query);
      $data_supplier        = mysqli_fetch_array($data_supplier_result, MYSQLI_ASSOC);

      $nama_supplier  = $data_supplier['nama'];
      $alamat_supplier= $data_supplier['alamat'];

      $total_harga_semua = 0;

      for($i=0; $i<$jumlah_transaksi; $i++){
        $id_bahan_post = mysqli_real_escape_string($conn, $_POST['id_bahan_'.$i]);
        if($id_bahan_post == 'other'){
          $nama[$i]       = mysqli_real_escape_string($conn, $_POST['nama_bahan_input_'.$i]);
        }else{
          $nama_bahan_query[$i]   = "SELECT nama FROM tb_bahan WHERE id_bahan = '$id_bahan_post' LIMIT 1";
          $nama_bahan_result[$i]  = mysqli_query($conn, $nama_bahan_query[$i]);
          $nama_bahan[$i]         = mysqli_fetch_array($nama_bahan_result[$i], MYSQLI_ASSOC);
          $nama[$i]               = $nama_bahan[$i]['nama'];
        }

        $jumlah[$i]     = (int) filter_var($_POST['jumlah_'.$i], FILTER_SANITIZE_NUMBER_INT);
        $satuan[$i]     = mysqli_real_escape_string($conn, $_POST['satuan_'.$i]);

        $total_harga[$i] = (int) filter_var($_POST['total_harga_'.$i], FILTER_SANITIZE_NUMBER_INT);
        $harga[$i]       = $total_harga[$i] / $jumlah[$i];

        $total_harga_semua = $total_harga_semua + $total_harga[$i];
      }

      $id_user  = $_SESSION['id_user'];

      for($i=0;$i<$jumlah_transaksi;$i++){
         if($id_bahan_post == 'other'){
        /* Jika Bahan Belum Tersedia Atau Pembelian Bahan Baru */
          $tambah_bahan_query[$i] =
            "INSERT INTO tb_bahan (created_at, updated_at, nama, stok, satuan)
              VALUES ('$tanggal', '$tanggal', '$nama[$i]', '$jumlah[$i]', '$satuan[$i]')";
          $tambah_bahan_result[$i] = mysqli_query($conn, $tambah_bahan_query[$i]) or 
            die(mysqli_error($conn));
          $id_bahan[$i] = mysqli_insert_id($conn);
        }else{
          $update_bahan_query[$i] =
            "UPDATE tb_bahan
            SET updated_at = '$tanggal',
              stok         = stok + $jumlah[$i]
            WHERE id_bahan = '$id_bahan_post' 
            LIMIT 1
            ";
          $update_bahan_result[$i] = mysqli_query($conn, $update_bahan_query[$i]) or 
            die(mysqli_error($conn));
          $id_bahan[$i] = $id_bahan_post;
        }
      }

      $transaksi_beli_query =
        "INSERT INTO tb_transaksi_beli (created_at, total_harga, id_supplier)
          VALUES ('$tanggal', '$total_harga_semua', '$id_supplier')";
      $transaksi_beli_result = mysqli_query($conn, $transaksi_beli_query) or 
        die(mysqli_error($conn));
      $id_transaksi_beli = mysqli_insert_id($conn);

      for($i=0; $i<$jumlah_transaksi;$i++){
        $transaksi_beli_detail_query[0] =
          "INSERT INTO tb_transaksi_beli_detail (id_transaksi_beli, id_bahan, jumlah, satuan, harga, total_harga)
            VALUES ('$id_transaksi_beli', '$id_bahan[$i]', '$jumlah[$i]', '$satuan[$i]', '$harga[$i]','$total_harga[$i]')";
        $transaksi_beli_detail_result[0] = mysqli_query($conn, $transaksi_beli_detail_query[0]) or 
          die(mysqli_error($conn));
      }

      $add_bahan_msg = "Bahan berhasil ditambahkan";
      header( "Refresh:3; url=".$base_url."laporan-transaksi-beli.php", true, 303);
    }

    /* List Semua Supplier */
    $list_supplier_query    = "SELECT * FROM tb_supplier";
    $list_supplier_result   = mysqli_query($conn, $list_supplier_query);
    $data_supplier_arr      = array();
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
          <li class="breadcrumb-item "><a href="<?= $base_url; ?>">Home</a></li>
          <li class="breadcrumb-item active">Transaksi Beli</li>
        </ol>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <i class="fa fa-edit"></i>Form Pembelian Bahan
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
                <form style="margin-bottom: 25px" method="GET">
                  <div class="form-row">
                    <div class="col-5">         
                      <?php if(isset($_GET['jumlah_transaksi'])){
                        $jumlah_transaksi = $_GET['jumlah_transaksi'];
                      }else{
                        $jumlah_transaksi = 1;
                      } ?>             
                      <input class="form-control" id="prependedInput" size="16" type="number" name="jumlah_transaksi"  required="" placeholder="Jumlah Transaksi Bahan" value="<?= $jumlah_transaksi; ?>">
                    </div>
                    <div class="col-3">
                      <button class="btn btn-primary">Tambah</button>
                    </div>
                  </div>
                </form>
                <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="jumlah_transaksi" value="<?= $jumlah_transaksi; ?>">
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
                  <?php
                    $no = 1;
                    for($i=0; $i<$jumlah_transaksi; $i++){ 
                  ?>
                    <div class="wrap-element-bahan">
                      <div class="form-group">
                        <label class="col-form-label" for="prependedInput">Nama</label>
                        <div class="controls">
                          <div class="input-prepend input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">@</span>
                            </div>
                            <select name="id_bahan_<?= $i; ?>" required="" class="form-control select2 nama-bahan-select">
                              <option disabled selected value="">Bahan</option>
                              <option value="other">Ketik Baru</option>
                              <?php
                                   /* List Semua Bahan */
                                $list_bahan_query       = "SELECT id_bahan, nama, satuan FROM tb_bahan";
                                $list_bahan_result      = mysqli_query($conn, $list_bahan_query);
                                $data_satuan_bahan_arr  = array();
                                while($bahan = mysqli_fetch_array($list_bahan_result, MYSQLI_ASSOC)){
                                  echo "<option value = \"$bahan[id_bahan]\">$bahan[nama]</option>";
                                  $data_satuan_bahan_arr[$bahan['id_bahan']] = $bahan['satuan'];
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group" style="display: none;">
                        <label class="col-form-label" for="prependedInput">Ketikan Nama Bahan</label>
                        <div class="controls">
                          <div class="input-prepend input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">@</span>
                            </div>
                            <input class="form-control nama-bahan-input" id="prependedInput" size="16" type="text" name="nama_bahan_input_<?= $i; ?>" required="" disabled>
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
                            <input class="form-control" id="prependedInput" size="16" type="number" name="jumlah_<?= $i; ?>"  required="">
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
                            <input class="form-control" id="prependedInput" size="16" type="text" name="satuan_<?= $i; ?>"  required="">
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
                            <input class="form-control" id="prependedInput" onkeyup="FormatCurrency(this)" size="16" type="text" name="total_harga_<?= $i; ?>" required="">
                          </div>
                        </div>
                      </div>
                      <br/>
                      <hr/>
                      <br/>
                    </div><!-- End .wrap-element-bahan -->
                  <?php
                    }
                  ?>
                  <!-- Produk Yg Akan Ditransaksikan -->
                  <div class="wrap-multiple-transaksi wrap-form-clone">
                    <!-- Wrapper Form Clone -->
                  </div><!-- End .wrap-multiple-transaksi -->
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
  <div style="display: none">
    <div class="form-clone">
      <div class="form-group">
        <label class="col-form-label" for="prependedInput">Nama</label>
        <div class="controls">
          <div class="input-prepend input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">@</span>
            </div>
            <select name="id_bahan[]" required="" class="form-control nama-bahan-select">
              <option disabled selected value="">Bahan</option>
              <option value="other">Ketik Baru</option>
              <?php
                while($bahan = mysqli_fetch_array($list_bahan_result, MYSQLI_ASSOC)){
                  echo "<option value = \"$bahan[id_bahan]\">$bahan[nama]</option>";
                  $data_satuan_bahan_arr[$bahan['id_bahan']] = $bahan['satuan'];
                }
              ?>
            </select>
          </div>
        </div>
      </div>
      <div class="form-group" style="display: none;">
        <label class="col-form-label" for="prependedInput">Ketikan Nama Bahan</label>
        <div class="controls">
          <div class="input-prepend input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">@</span>
            </div>
            <input class="form-control nama-bahan-input" id="prependedInput" size="16" type="text" name="nama_bahan_input[]" required="" disabled>
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
            <input class="form-control" id="prependedInput" size="16" type="number" name="jumlah[]"  required="">
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
            <input class="form-control" id="prependedInput" size="16" type="text" name="satuan[]"  required="">
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
            <input class="form-control" id="prependedInput" onkeyup="FormatCurrency(this)" size="16" type="text" name="total_harga[]" required="">
          </div>
        </div>
      </div>
    </div><!-- End .form-clone -->
  </div><!-- display none end -->
  <script type="text/javascript">
    var data_supplier = <?= json_encode($data_supplier_arr); ?>;
    var data_satuan_bahan = <?= json_encode($data_satuan_bahan_arr); ?>;
  </script>
  <?php include 'layout/bottom.php'; ?>
  </body>
</html>