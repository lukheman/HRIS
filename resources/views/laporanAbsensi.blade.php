<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Gaji</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }

    .laporan-absensi th,
    .laporan-absensi td {
      text-align: left;
      padding: 8px;
      border: 2px solid black;
    }

    th {
      background-color: #f4f4f4;
    }

    @media print {
      body {
        margin: 0;
        padding: 0;
        font-size: 8px;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        overflow: hidden;
      }

      th,
      td {
        border: 2px solid #000;
        padding: 8px;
      }

      table,
      tr,
      td,
      th {
        page-break-inside: avoid;
      }

      @page {
        size: A4 portrait;
        margin: 1cm;
      }
    }

    hr {
      width: 100%;
      border-width: 3px;
      background-color: black;
    }

    .biodata {
      border-collapse: separate;
      border-spacing: 10px 10px;
      border: 0px;
      font-weight: bold;
    }
  </style>
</head>

<body onload="window.print()">
  <div class="container mt-5">
    <center>
      <h3>PT FATWA BUMI SEJAHTERA</h3>
      <p>CWJ8+G4, Pitulua, Kec. Lasusua, Kabupaten Kolaka Utara, Sulawesi Tenggara</p>
      <hr>
    </center>
    @if (isset($karyawan))
    <table class="biodata">
      <tr>
        <td>Nama </td>
        <td>: {{ $karyawan->nama }}</td>
      </tr>
      <tr>
        <td>NIK </td>
        <td>: {{ $karyawan->nik }}</td>
      </tr>

      <tr>
        <td>Jabatan </td>
        <td>: {{ $karyawan->jabatan }}</td>
      </tr>
    </table>
    @endif
    <div class="row">
      <div class="col-6">
        <h4>Laporan Harian</h4>
      </div>
      <div class="col-6">
        <p class="float-right">
          <b>
            Dari {{ $start_date }} s/d {{ $end_date }}
          </b>
        </p>
      </div>
    </div>
    <table class="laporan-absensi">
      <thead>
        <tr>
          @if (!isset($karyawan))
          <th>Nama</th>
          @endif
          @foreach ($header_date as $tanggal)
          <td>{{ $tanggal }}</td>

          @endforeach
        </tr>
      </thead>
      <tbody>
        @foreach ($listAbsensi as $absensi)
        <tr>
          @if (!isset($karyawan))
          <td>{{ $absensi->nama_karyawan}}</td>
          @endif
          @php
          $tanggalHadir = explode(", ", $absensi->tanggal_hadir); // Ubah string tanggal hadir menjadi array
          $tanggalAlpha = explode(", ", $absensi->tanggal_alpha); // Ubah string tanggal hadir menjadi array
          @endphp

          @foreach ($header_date as $tanggal)
          @if (in_array($tanggal, $tanggalHadir))
          <td>H</td>
          @elseif (in_array($tanggal, $tanggalAlpha))
          <td>A</td>
          @else
          <td></td>
          @endif

          @endforeach

        </tr>
        @endforeach

      </tbody>
    </table>
    <p><small>Hadir = "H", Alpha = "A"</small></p>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>
