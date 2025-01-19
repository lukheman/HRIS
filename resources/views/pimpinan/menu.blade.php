<li class="nav-item">
  <a href="@base_url(/pimpinan)" class="nav-link {{ $page === 'Dashboard' ? 'active' : ''}}">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
      Dashboard
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="@base_url(/pimpinan/gaji-karyawan)" class="nav-link {{ $page === 'Gaji Karyawan' ? 'active' : ''}}">
    <i class="nav-icon fas fa-money-check-alt"></i>
    <p>
      Gaji Karyawan
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="@base_url(/pimpinan/absensi/all)" class="nav-link {{ $page === 'Absensi Karyawan' ? 'active' : ''}}">
    <i class="nav-icon fas fa-calendar-check"></i>
    <p>
      Absensi Karyawan
    </p>
  </a>
</li>
