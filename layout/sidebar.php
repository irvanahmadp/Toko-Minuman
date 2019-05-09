<nav class="sidebar-nav">
  <ul class="nav">
    <?php if($_SESSION['level']=='A'){ ?>
      <li class="nav-item  nav-dropdown  active">
        <a class="nav-link  nav-dropdown-toggle " href="#">
          <i class="fas fa-coffee" style="margin-right: 7.5px"></i>
          Produk
        </a>
        <ul class="nav-dropdown-items">
          <li class="nav-item active docs-sidenav-active">
            <a class="nav-link" href="<?= $base_url; ?>tambah-produk.php">
              Tambah Minuman
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="<?= $base_url; ?>produk.php">
              Jual Minuman
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item docs-sidenav-active">
        <a class="nav-link" href="<?= $base_url; ?>bahan.php">
          <i class="fas fa-warehouse" style="margin-right: 7.5px"></i>
          Bahan
        </a>
      </li>
    <?php }else{ ?>
      <li class="nav-item docs-sidenav-active">
        <a class="nav-link" href="<?= $base_url; ?>produk.php">
          <i class="fas fa-coffee" style="margin-right: 7.5px"></i>
          Minuman
        </a>
      </li>
    <?php } ?>
    <li class="nav-item nav-dropdown">
      <a class="nav-link  nav-dropdown-toggle " href="#">
        <i class="fas fa-list-alt" style="margin-right: 7.5px"></i>
        Laporan
      </a>
      <ul class="nav-dropdown-items">
        <li class="nav-item active docs-sidenav-active">
          <a class="nav-link" href="<?= $base_url; ?>laporan-transaksi.php">
            Transaksi
          </a>
        </li>
        <li class="nav-item ">
          <a class="nav-link" href="<?= $base_url; ?>laporan-mutasi.php">
            Mutasi
          </a>
        </li>
      </ul>
    </li>
  </ul>
</nav>