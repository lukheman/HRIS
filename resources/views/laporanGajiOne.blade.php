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
      font-weight: bold;
    }

    .table-laporan {
      width: 100%;
      border-collapse: collapse;
    }

    .table-laporan th,
    .table-laporan td,
    .table-laporan td {
      text-align: left;
      padding: 8px;
      border: 2px solid black;
    }

    th {
      background-color: #f4f4f4;
    }

    center {
      font-family: 'Times New Roman', Times, serif;
    }

    center h3 {
      font-weight: bold;
    }

    hr {
      border-width: 3px;
      background-color: black;
    }

    .biodata {
      border-collapse: separate;
      /* Harus diatur ke 'separate' */
      border-spacing: 10px 10px;
      /* 0 untuk horizontal, 10px untuk vertical */
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
    <table class="biodata">

      <tr>
        <td>Nama: </td>
        <td>{{ $karyawan->nama }}</td>
      </tr>
      <tr>
        <td>NIK: </td>
        <td>{{ $karyawan->nik }}</td>
      </tr>

      <tr>
        <td>Jabatan: </td>
        <td>{{ $karyawan->jabatan }}</td>
      </tr>
    </table>
    <br>
    <h4>REKAP GAJI PERIODE
      @if ($start_date === $end_date)
      {{ $start_date }}
      @else
      {{ $start_date .' - '. $end_date}}
      @endif
    </h4>
    <table class="table-striped table-laporan">
      <thead>
        <tr>
          @if ($start_date !== $end_date)
          <th>Periode</th>
          @endif
          <!-- <th>Jabatan</th> -->
          <th>Gaji Pokok</th>
          <th>Total Durasi Lembur (Jam)</th>
          <th>Gaji Lembur</th>
          <th>Total Gaji</th>
        </tr>
      </thead>
      <tbody>
        @php
        $total_gaji_pokok = 0;
        $total_durasi_lembur = 0;
        $total_gaji_lembur = 0;
        $total_gaji_total = 0;
        @endphp

        @foreach ($listKaryawan as $karyawan)
        <tr>
          @if ($start_date !== $end_date)
          <td>{{ $karyawan->periode }}</td>
          @endif
          <td><strong>Rp {{ number_format($karyawan->gaji_pokok, 2, ',', '.') }}</strong></td>
          <td>{{ $karyawan->total_lembur }}</td>
          <td><strong>Rp {{ number_format($karyawan->gaji_lembur, 2, ',', '.') }}</strong></td>
          <td><strong>Rp {{ number_format($karyawan->gaji_total, 2, ',', '.') }}</strong></td>
          @php
          $total_gaji_pokok += $karyawan->gaji_pokok;
          $total_gaji_lembur += $karyawan->gaji_lembur;
          $total_gaji_total += $karyawan->gaji_total;
          $total_durasi_lembur += $karyawan->total_lembur;
          @endphp
        </tr>
        @endforeach
        <tr>
          @if ($start_date !== $end_date)

          <td><strong>Total</strong></td>
          <td>
            <strong>
              Rp. {{ number_format($total_gaji_pokok, 2, ',', '.') }}
            </strong>
          </td>
          <td><strong>
              {{ $total_durasi_lembur }} Jam
            </strong></td>
          <td> <strong> Rp. {{ number_format($total_gaji_lembur, 2, ',', '.') }}</strong></td>
          <td><strong> Rp. {{ number_format($total_gaji_total, 2, ',', '.') }}</strong></td>
        </tr>
        @endif

      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>
