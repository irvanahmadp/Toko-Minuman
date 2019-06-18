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
      // Untuk produk, harga adalah harga jual
      $stok       = (int) filter_var($_POST['stok'], FILTER_SANITIZE_NUMBER_INT);
      $imageFileType = strtolower(pathinfo($_FILES["gambar"]["name"],PATHINFO_EXTENSION));
      $alamat_img = 'produk' . rand(100, 999) . date('YmdHis') . '.' .$imageFileType;
      
      $target_dir   = "images/";
      $target_file  = $target_dir . $alamat_img;
      $uploadOk     = 1;

      // Check if image file is a actual image or fake image
      $check = getimagesize($_FILES["gambar"]["tmp_name"]);
      if($check !== false) {
          //echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
      } else {
          //echo "File is not an image.";
          $uploadOk = 0;
      }

      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
          //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
      }

      if($uploadOk == 1) {
        if (!move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
          /* Jika upload gagal */
          $alamat_img = '404';
        }
      }

      $tambah_produk_query = 
        "INSERT INTO tb_produk (created_at, updated_at, nama, harga, stok, img)
          VALUES ('$tanggal', '$tanggal', '$nama', '$harga', '$stok', '$alamat_img')";
      $tambah_produk_result = mysqli_query($conn, $tambah_produk_query) or die(mysqli_error($conn));
      $id_produk = mysqli_insert_id($conn);

      $add_produk_msg = "Produk berhasil ditambahkan";
      header( "Refresh:3; url=".$base_url."produk.php", true, 303);
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Tambah Produk</title>
  <?php include 'layout/head.php'; ?>
</head>
<body class="app header-fixed sidebar-md-show sidebar-fixed">
  <header class="app-header navbar">
    <?php include 'layout/header.php'; ?>
  </header>
  <div class="app-body">
    <div class="message-alert body">
      <?php if(isset($add_produk_msg) && $add_produk_msg != ''){ ?>
        <div class="alert alert-success">
          <center>
            <strong>
              <?= $add_produk_msg; ?>
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
          <li class="breadcrumb-item "><a href="<?= $base_url; ?>produk.php">Produk</a></li>
          <li class="breadcrumb-item active">Tambah Produk</li>
        </ol>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <i class="fa fa-edit"></i>Form Penambahan Produk
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
                    <label class="col-form-label" for="prependedInput">Harga Jual Satuan</label>
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
                    <label class="col-form-label" for="prependedInput">Stok</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Jml</span>
                        </div>
                        <input class="form-control" id="prependedInput" size="16" type="number" name="stok"  required="">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-form-label" for="prependedInput">Foto/Gambar</label>
                    <div class="controls">
                      <div class="input-prepend input-group">
                        <input id="file-input" type="file" name="gambar" required=""
                          accept="image/*">
                      </div>
                    </div>
                  </div>
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
  <?php include 'layout/bottom.php'; ?>
  </body>
</html>