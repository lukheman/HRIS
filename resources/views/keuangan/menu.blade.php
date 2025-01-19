<li class="nav-item">
  <a href="@base_url(/keuangan)" class="nav-link {{ $page === 'dashboard' ? 'active' : ''}}">
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
      Gaji Karyawan
      <!-- <span class="right badge badge-danger">New</span> -->
    </p>
  </a>
</li>

<!--<li class="nav-item">-->
<!--  <a href="@base_url(/keuangan/gajiKaryawan/verifikasiShow)"-->
<!--    class="nav-link {{ $page === 'Verifikasi Gaji Karyawan' ? 'active' : ''}}">-->
<!--    <i class="nav-icon fas fa-th"></i>-->
<!--    <p>-->
<!--      Verifikasi Gaji Karyawan-->
<!--      <!-- <span class="right badge badge-danger">New</span> -->-->
<!--    </p>-->
<!--  </a>-->
<!--</li>-->
