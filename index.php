<?php
  include 'config/conn.php';
  include 'config/url.php';
  include 'function/check-login.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Toko Minuman</title>
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
          <li class="breadcrumb-item "><a href="https://coreui.io/docs/">Docs</a></li>
          <li class="breadcrumb-item active">UI Kit</li>
        </ol>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12  col-xl-9 ">
            <div class="card">
              <div class="card-body">
                <h1 class="docs-title" id="content">CoreUI UI Kit</h1>
              </div>
            </div>
          </div>
          <div class="d-none d-xl-block col-xl-3 toc">
            <div class="card">
              <div class="card-body">
                <ul class="section-nav">
                  <li class="toc-entry toc-h2"><a href="#color-pallete">Color pallete</a></li>
                  <li class="toc-entry toc-h2"><a href="#grays">Grays</a></li>
                  <li class="toc-entry toc-h2"><a href="#typography">Typography</a></li>
                  <li class="toc-entry toc-h2"><a href="#bootstrap-alerts">Bootstrap alerts</a></li>
                  <li class="toc-entry toc-h2"><a href="#bootstrap-badges">Bootstrap badges</a></li>
                  <li class="toc-entry toc-h2"><a href="#bootstrap-breadcrumb">Bootstrap breadcrumb</a></li>
                  <li class="toc-entry toc-h2">
                    <a href="#bootstrap-buttons">Bootstrap buttons</a>
                    <ul>
                      <li class="toc-entry toc-h3"><a href="#standard-buttons">Standard buttons</a></li>
                      <li class="toc-entry toc-h3"><a href="#outline-buttons">Outline buttons</a></li>
                      <li class="toc-entry toc-h3"><a href="#ghost-buttons">Ghost buttons</a></li>
                      <li class="toc-entry toc-h3"><a href="#square-buttons">Square buttons</a></li>
                      <li class="toc-entry toc-h3"><a href="#pill-buttons">Pill buttons</a></li>
                      <li class="toc-entry toc-h3"><a href="#loading-buttons">Loading buttons</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  <footer class="app-footer">
    <div>
      <a href="https://coreui.io">CoreUI</a>
      <span>&copy; 2018 creativeLabs.</span>
    </div>
    <div class="ml-auto">
      <span>Powered by</span>
      <a href="https://coreui.io">CoreUI</a>
    </div>
  </footer>
  <?php include 'layout/bottom.php'; ?>
  </body>
</html>