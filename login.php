<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';
  if($_SERVER['REQUEST_METHOD']=='POST'){
    $kontak   = $_POST['kontak'];
    $password = md5($_POST['password']);
    $login_query  = "SELECT id_user, nama, email,telp, level from tb_user WHERE (telp = '$kontak' or email = '$kontak') and password = '$password'";
    $login_result = mysqli_query($conn, $login_query);
    if(mysqli_num_rows($login_result) > 0){
      /* JIka Login Sukses */
      $result_arr = mysqli_fetch_array($login_result);
      $_SESSION['id_user']= $result_arr['id_user'];
      $_SESSION['nama']   = $result_arr['nama'];
      $_SESSION['telp']   = $result_arr['telp'];
      $_SESSION['email']  = $result_arr['email'];
      $_SESSION['level']  = $result_arr['level'];
      
      header("Location:".$base_url.'index.php');
      
    }else{
      /* Jika Login Gagal */
      $login_error_msg = "Email atau password salah";
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <?php include 'layout/head.php'; ?>
</head>
<body class="app flex-row align-items-center">
  <div class="message-alert">
    <?php if(isset($login_error_msg) && $login_error_msg != ''){ ?>
      <div class="alert alert-danger">
        <center>
          <strong>
            <?= $login_error_msg; ?>
          </strong>
        </center>
      </div>
    <?php } ?>
  </div>
	<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card-group">
          <div class="card p-4">
            <center>
              <h1>Login</h1>
              <p class="text-muted">Sign In to your account</p>
            </center>
            <div class="card-body">
              <form method="post">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-user"></i>
                    </span>
                  </div>
                  <input class="form-control" type="text" placeholder="Email atau No. Telp" name="kontak">
                </div>
                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-unlock"></i>
                    </span>
                  </div>
                  <input class="form-control" type="password" placeholder="Password" name="password">
                </div>
                <div class="row">
                  <div class="col-12">
                    <button class="btn btn-primary btn-block">Login</button>
                  </div>
                </div>
                <div class="row" style="margin-top: 15px">
                  <div class="col-12">
                    <a class="btn btn-success btn-block" 
                      href="<?= $base_url; ?>register.php" 
                      role="button">
                      Daftar
                    </a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
	</div>
	<?php include 'layout/bottom.php'; ?>
  </body>
</html>