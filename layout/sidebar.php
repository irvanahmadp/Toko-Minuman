<nav class="sidebar-nav">
  <ul class="nav">
    <?php if($_SESSION['level']=='A'){ /* Jika Admin */ ?>
      <li class="nav-item nav-dropdown">
        <a class="nav-link  nav-dropdown-toggle " href="#">
          <i class="fas fa-list-alt" style="margin-right: 7.5px"></i>
          Produk
        </a>
        <ul class="nav-dropdown-items">
          <li class="nav-item docs-sidenav-active">
            <a class="nav-link" href="<?= $base_url; ?>produk.php">
              Daftar Produk
            </a>
          </li>
          <li class="nav-item docs-sidenav-active">
            <a class="nav-link" href="<?= $base_url; ?>tambah-produk.php">
              Tambah Produk
            </a>
          </li>
          <li class="nav-item docs-sidenav-active">
            <a class="nav-link" href="<?= $base_url; ?>transaksi.php">
              Transaksi Jual
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item nav-dropdown">
        <a class="nav-link  nav-dropdown-toggle " href="#">
          <i class="fas fa-list-alt" style="margin-right: 7.5px"></i>
          Bahan
        </a>
        <ul class="nav-dropdown-items">
          <li class="nav-item docs-sidenav-active">
            <a class="nav-link" href="<?= $base_url; ?>bahan.php">
              Daftar Bahan
            </a>
          </li>
          <li class="nav-item docs-sidenav-active">
            <a class="nav-link" href="<?= $base_url; ?>daftar-pengurangan-stok-bahan.php">
              Penggunaan Bahan
            </a>
          </li>
          <li class="nav-item docs-sidenav-active">
            <a class="nav-link" href="<?= $base_url; ?>transaksi-beli.php">
              Tambah Bahan
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item docs-sidenav-active">
        <a class="nav-link" href="<?= $base_url; ?>supplier.php">
          <i class="fas fa-warehouse" style="margin-right: 7.5px"></i>
          Supplier
        </a>
      </li>
      <li class="nav-item nav-dropdown">
        <a class="nav-link  nav-dropdown-toggle " href="#">
          <i class="fas fa-list-alt" style="margin-right: 7.5px"></i>
          Laporan
        </a>
        <ul class="nav-dropdown-items">
          <li class="nav-item active docs-sidenav-active">
            <a class="nav-link" href="<?= $base_url; ?>laporan-transaksi.php">
              Transaksi Jual
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="<?= $base_url; ?>laporan-transaksi-beli.php">
              Transaksi Beli
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="<?= $base_url; ?>laporan-mutasi.php">
              Mutasi
            </a>
          </li>
        </ul>
      </li>
    <?php }else{ /* Jika Bukan Admin */?>
      <li class="nav-item docs-sidenav-active">
        <a class="nav-link" href="<?= $base_url; ?>produk.php">
          <i class="fas fa-coffee" style="margin-right: 7.5px"></i>
          Beli Minuman
        </a>
      </li>
    <!-- Semua Member -->
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
      </ul>
    </li>
    <?php } ?>
  </ul>
</nav>