<!-- <li class="nav-item"> -->
<!--   <a href="@base_url(/karyawan)" class="nav-link {{ $page === 'dashboard' ? 'active' : ''}}"> -->
<!--     <i class="nav-icon fas fa-tachometer-alt"></i> -->
<!--     <p> -->
<!--       Dashboard Karyawan -->
<!--     </p> -->
<!--   </a> -->
<!-- </li> -->

<li class="nav-item">
  <a href="@base_url(/karyawan/profile)" class="nav-link {{ $page === 'Profile' ? 'active' : ''}}">
    <i class="nav-icon fas fa-user"></i>
    <p>
      Profile
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="@base_url(/karyawan/absensi/detail?id={{ $_SESSION['user_id']}}&periode={{ date('Y-m')}})"
    class="nav-link {{ $page === 'Absensi Karyawan' ? 'active' : ''}}">
    <i class="nav-icon fas fa-calendar-check"></i>
    <p>
      Absensi
    </p>
  </a>
</li>

<li class="nav-item">
  <a href="@base_url(/karyawan/gaji-karyawan/detail)" class="nav-link {{ $page === 'Gaji Karyawan' ? 'active' : ''}}">
    <i class="nav-icon fas fa-money-check-alt"></i>
    <p>
      Laporan Gaji
    </p>
  </a>
</li>

<!--<li class="nav-item">-->
<!--  <a href="@base_url(/karyawan/absensi/generate-qrcode)"-->
<!--    class="nav-link {{ $page === 'Generate QR Code' ? 'active' : ''}}">-->
<!--    <i class="nav-icon fas fa-qrcode"></i>-->
<!--    <p>-->
<!--      Generate QR Code-->
<!--    </p>-->
<!--  </a>-->
<!--</li>-->

<!-- <li class="nav-item"> -->
<!--   <a href="@base_url(/karyawan/absensi/scan-qrcode)" class="nav-link {{ $page === 'Scan QR Code' ? 'active' : ''}}"> -->
<!--     <i class="nav-icon fas fa-video"></i> -->
<!--     <p> -->
<!--       Scan QR Code -->
<!--     </p> -->
<!--   </a> -->
<!-- </li> -->
