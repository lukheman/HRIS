<li class="nav-item">
  <a href="@base_url(/hrd)" class="nav-link {{ $page === 'Dashboard' ? 'active' : ''}}">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>
      Dashboard
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="@base_url(/hrd/karyawan)" class="nav-link {{ $page === 'Daftar Karyawan' ? 'active' : ''}}">
    <i class="nav-icon fas fa-table"></i>
    <p>
      Daftar Karyawan
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="@base_url(/hrd/absensi/all)" class="nav-link {{ $page === 'Absensi Karyawan' ? 'active' : ''}}">
    <i class="nav-icon fas fa-calendar-check"></i>
    <p>
      Absensi Karyawan
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="@base_url(/hrd/gaji-karyawan)" class="nav-link {{ $page === 'Gaji Karyawan' ? 'active' : ''}}">
    <i class="nav-icon fas fa-money-check-alt"></i>
    <p>
      Laporan Gaji
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="@base_url(/hrd/absensi/generate-qrcode)" class="nav-link {{ $page === 'Generate QR Code' ? 'active' : ''}}">
    <i class="nav-icon fas fa-qrcode"></i>
    <p>
      Generate QR Code
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="@base_url(/hrd/absensi/scan-qrcode)" class="nav-link {{ $page === 'Scan QR Code' ? 'active' : ''}}">
    <i class="nav-icon fas fa-video"></i>
    <p>
      Scan QR Code
    </p>
  </a>
</li>
