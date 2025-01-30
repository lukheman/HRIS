<li class="nav-item">
  <a href="@base_url(/keuangan)" class="nav-link {{ $page === 'Dashboard' ? 'active' : ''}}">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
      Dashboard Keuangan
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="@base_url(/keuangan/gaji-karyawan)" class="nav-link {{ $page === 'Gaji Karyawan' ? 'active' : ''}}">
    <i class="nav-icon fas fa-money-check-alt"></i>
    <p>
      Laporan Gaji Karyawan
      <!-- <span class="right badge badge-danger">New</span> -->
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="@base_url(/keuangan/absensi/all)" class="nav-link {{ $page === 'Absensi Karyawan' ? 'active' : ''}}">
    <i class="nav-icon fas fa-calendar-check"></i>
    <p>
      Absensi Karyawan
    </p>
  </a>
</li>
