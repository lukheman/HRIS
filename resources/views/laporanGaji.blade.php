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
      font-weight: bold;
    }

    th,
    td,
    tr {
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
  </style>
</head>

<body onload="window.print()">
  <div class="container mt-5">
    <center>
      <h3>PT FATWA BUMI SEJAHTERA</h3>
      <p>CWJ8+G4, Pitulua, Kec. Lasusua, Kabupaten Kolaka Utara, Sulawesi Tenggara</p>
      <hr>
    </center>
    <h4>REKAP GAJI PERIODE
      @if ($start_date === $end_date)
      {{ $start_date }}
      @else
      {{ $start_date .' - '. $end_date}}
      @endif
    </h4>
    <table class="table-striped">
      <thead>
        <tr>
          @if ($start_date !== $end_date)
          <th>Periode</th>
          @endif
          <th>Nama</th>
          <!-- <th>Jabatan</th> -->
          <th>Gaji Pokok</th>
          <th>Total Durasi Lembur (Menit)</th>
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
          <td>{{ $karyawan->nama }}</td>
          <!-- <td>{{ $karyawan->jabatan }}</td> -->
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
          <td><strong>Total</strong></td>
          @if ($start_date !== $end_date)
          <td></td>
          @endif
          <td>
            <strong>
              Rp. {{ number_format($total_gaji_pokok, 2, ',', '.') }}
            </strong>
          </td>
          <td><strong>
              {{ $total_durasi_lembur }} Menit
            </strong></td>
          <td> <strong> Rp. {{ number_format($total_gaji_lembur, 2, ',', '.') }}</strong></td>
          <td><strong> Rp. {{ number_format($total_gaji_total, 2, ',', '.') }}</strong></td>
        </tr>

      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>
