@extends('layouts.main')

@section('title', 'Scan Qr Code')

@section('sidebar-menu')

@include('hrd.menu')

@endsection

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">

          </div>
          <div class="card-body">
            <video id="preview"></video>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  let scanner = new Instascan.Scanner({video: document.getElementById('preview')});

  scanner.addListener('scan', function (content) {
    // Kirim hasil scan ke server
    fetch('/hrd/process-scan', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: JSON.stringify({
        nik: content
      })
    })
      .then(response => response.text())
      .then(result => {
        document.getElementById('result').innerHTML = "Status Absensi: Berhasil";
      });
  });

  Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
      scanner.start(cameras[0]);
    } else {
      console.error('Kamera tidak ditemukan.');
    }
  });
</script>
@endsection
