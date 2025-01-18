<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Slip Gaji Karyawan</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .slip-container {
      margin: 20px auto;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      max-width: 700px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .slip-header {
      text-align: center;
      margin-bottom: 20px;
    }

    .slip-header h2 {
      margin: 0;
    }

    .details-table th,
    .details-table td {
      padding: 10px;
    }
  </style>
</head>

<body>

  <div class="slip-container">
    <div class="slip-header">
      <h2>Slip Gaji Karyawan</h2>
      <p>Periode: {{ $karyawan->periode }}</p>
    </div>
    <table class="table details-table">
      <tr>
        <th>Nama</th>
        <td>{{ $karyawan->nama }}</td>
      </tr>
      <tr>
        <th>Jabatan</th>
        <td>{{ $karyawan->jabatan }}</td>
      </tr>
      <tr>
        <th>Gaji Pokok</th>
        <td>Rp {{ number_format($karyawan->gaji_pokok, 2, ',', '.') }}</td>
      </tr>
      <tr>
        <th>Gaji Lembur</th>
        <td>Rp {{ number_format($karyawan->gaji_lembur, 2, ',', '.') }}</td>
      </tr>
      <tr>
        <th>Total Gaji</th>
        <td><strong>Rp {{ number_format($karyawan->gaji_total, 2, ',', '.') }}</strong></td>
      </tr>
    </table>

    <div class="text-center mt-4">
      <p><em>Slip gaji ini dibuat secara otomatis dan sah tanpa tanda tangan.</em></p>
    </div>
  </div>

</body>

</html>
