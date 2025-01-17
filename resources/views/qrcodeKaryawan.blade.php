<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Karyawan</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .card-container {
      margin: 20px auto;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      max-width: 500px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .qr-code {
      margin-bottom: 20px;
    }

    .employee-name {
      font-size: 1.5em;
      font-weight: bold;
    }

    .employee-position {
      font-size: 1.2em;
      color: #555;
    }
  </style>
</head>

<body onload="window.print()">

  <div class="card-container">
    <div class="qr-code">
      <!-- <img src="{{ $qrPath }}" alt="QR Code" width="150" height="150"> -->

      <img src="data:image/png;base64, {{ $qrCodeBase64 }}" alt="QR Code">
    </div>
    <div class="employee-name">
      {{ $karyawan->nama }}
    </div>
    <div class="employee-position">
      {{ $karyawan->jabatan }}
    </div>
  </div>

</body>

</html>
