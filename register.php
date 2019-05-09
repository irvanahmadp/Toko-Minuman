<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';
  if($_SERVER['REQUEST_METHOD']=='POST'){
    $tanggal = date('Y-m-d H:i:s');
    
    $nama = $_POST["nama"];
    if (!preg_match("/^[a-zA-Z ]*$/",$nama)) {
      $namaErr = "Only letters and white space allowed";
    }

    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }

    $telp = (int) filter_var($_POST['telp'], FILTER_SANITIZE_NUMBER_INT);
    $password = md5($_POST['password']);

    if(!isset($namaErr) && !isset($emailErr)){
      $register_query = 
        "INSERT INTO tb_user (tanggal, nama, level, email, telp, password)
          VALUES ('$tanggal', '$nama', 'M', '$email', '$telp', '$password')";
      $register_result = mysqli_query($conn, $register_query);
      $id_user = mysqli_insert_id($conn);
      $_SESSION['id_user']= $id_user;
      $_SESSION['nama']   = $nama;
      $_SESSION['telp']   = $telp;
      $_SESSION['email']  = $email;
      $_SESSION['level']  = "M";
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <?php include 'layout/head.php'; ?>
</head>
  <body class="app flex-row align-items-center">
    <div class="message-alert">
    <?php if(isset($namaErr) && $namaErr != ''){ ?>
      <div class="alert alert-danger">
        <center>
          <strong>
            <?= $namaErr; ?>
          </strong>
        </center>
      </div>
    <?php } ?>
    <?php if(isset($emailErr) && $emailErr != ''){ ?>
      <div class="alert alert-danger">
        <center>
          <strong>
            <?= $emailErr; ?>
          </strong>
        </center>
      </div>
    <?php } ?>
  </div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card mx-4">
            <div class="card-body p-4">
              <form method="POST">
                <h1>Register</h1>
                <p class="text-muted">Create your account</p>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-user"></i>
                    </span>
                  </div>
                  <input class="form-control" type="text" placeholder="Nama" name="nama" required="">
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-envelope"></i>
                    </span>
                  </div>
                  <input class="form-control" type="email" placeholder="Email" name="email" required="">
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-mobile-alt"></i>
                    </span>
                  </div>
                  <input class="form-control" type="number" placeholder="No. Telp" name="telp" required="">
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-lock"></i>
                    </span>
                  </div>
                  <input class="form-control" type="password" placeholder="Password" name="password" minlength="7" maxlength="15">
                </div>
                <button class="btn btn-block btn-success">Create Account</button>
              </form>
            </div>
            <div class="card-footer p-4">
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include 'layout/bottom.php'; ?>
  </body>
</html>