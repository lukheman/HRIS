<li class="nav-item">
  <a href="/hrd" class="nav-link {{ $page === 'dashboard' ? 'active' : ''}}">
    <i class="nav-icon fas fa-th"></i>
    <p>
      Dashboard ak
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="/hrd/karyawan" class="nav-link {{ $page === 'karyawan' ? 'active' : ''}}">
    <i class="nav-icon fas fa-th"></i>
    <p>
      Daftar Karyawan
      <!-- <span class="right badge badge-danger">New</span> -->
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="/hrd/karyawanAddForm" class="nav-link {{ $page === 'karyawanAdd' ? 'active' : ''}}">
    <i class="nav-icon fas fa-th"></i>
    <p>
      Tambah Karyawan
      <!-- <span class="right badge badge-danger">New</span> -->
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="/hrd/absensi" class="nav-link {{ $page === 'absensi' ? 'active' : ''}}">
    <i class="nav-icon fas fa-th"></i>
    <p>
      Absensi Karyawan
      <!-- <span class="right badge badge-danger">New</span> -->
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="hrd.php?page=karyawan-absensi-bulan"
    class="nav-link {{ $page === 'karyawan-absensi-bulan' ? 'active' : ''}}">
    <i class="nav-icon fas fa-th"></i>
    <p>
      Absensi Perbulan
      <!-- <span class="right badge badge-danger">New</span> -->
    </p>
  </a>
</li>
