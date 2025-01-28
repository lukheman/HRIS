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

    th,
    td {
      text-align: left;
      padding: 8px;
      border: 1px solid #ddd;
    }

    th {
      background-color: #f4f4f4;
    }
  </style>
</head>

<body onload="window.print()">
  <div class="container mt-5">
    <h3>Data Gaji Karyawan</h3>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Periode</th>
          <th>Nama</th>
          <!-- <th>Jabatan</th> -->
          <th>Gaji Pokok</th>
          <th>Total Durasi Lembur (Jam)</th>
          <th>Gaji Lembur</th>
          <th>Total Gaji</th>
        </tr>
      </thead>
      <tbody>

        @foreach ($listKaryawan as $karyawan)
        <tr>
          <td>{{ $karyawan->periode }}</td>
          <td>{{ $karyawan->nama }}</td>
          <!-- <td>{{ $karyawan->jabatan }}</td> -->
          <td><strong>Rp {{ number_format($karyawan->gaji_pokok, 2, ',', '.') }}</strong></td>
          <td>{{ $karyawan->total_lembur }}</td>
          <td><strong>Rp {{ number_format($karyawan->gaji_lembur, 2, ',', '.') }}</strong></td>
          <td><strong>Rp {{ number_format($karyawan->gaji_total, 2, ',', '.') }}</strong></td>
        </tr>

        @endforeach

      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>
