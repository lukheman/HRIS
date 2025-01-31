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
      border-collapse: collapse;
      font-weight: bold;
    }

    #table-slip {
      margin-top: 10px;
    }

    #table-slip th,
    #table-slip td,
    #table-slip tr {
      text-align: left;
      border: 2px solid black;
      padding: 10px;
    }

    th {
      background-color: #f4f4f4;
    }

    center {
      font-family: 'Times New Roman', Times, serif;
    }

    hr {
      border-width: 3px;
      background-color: black;
    }

    #biodata th,
    #biodata td,
    #biodata tr {
      padding: 10px;
    }

    #slip-wrapper {
      width: 500px;
      margin: 0 auto;
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

    <div class="row" id="slip-wrapper">
      <div class="col-12">
        <table id="biodata">

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
          <tr>
            <td>Periode </td>
            <td>: {{ $karyawan->periode }}</td>
          </tr>

        </table>

      </div>
      <div class="col-12">

        <table id="table-slip">
          <thead>
            <tr>
              <th class="text-center" style="width: 20%;">Pendapatan</th>
              <th class="text-center">Jumlah (Rp)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Gaji Pokok</td>
              <td class="text-right">{{ number_format($karyawan->gaji_pokok, 2, ',', '.')}}</td>
            </tr>
            <tr>
              <td>Gaji Lembur</td>
              <td class="text-right">{{ number_format($karyawan->gaji_lembur, 2, ',', '.')}}</td>
            </tr>
            <tr>
              <td>Gaji Total</td>
              <td class="text-right">{{ number_format($karyawan->gaji_total, 2, ',', '.')}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>
