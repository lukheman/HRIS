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

            <div class="card card-danger" id="result-failed" style="display: none;">
              <div class="card-header">
                <h3 class="card-title">Gagal melakukan Absensi</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <p id="message-failed"></p>
              </div>
              <!-- /.card-body -->
            </div>

            <div class="card card-success" id="result-success" style="display: none;">
              <div class="card-header">
                <h3 class="card-title">Berhasil melakukan Absensi - <span id="message-success"></span></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <p><span id="nama-karyawan"></span> - <span id="jabatan-karyawan"></span></p>
              </div>
              <!-- /.card-body -->
            </div>

          </div>
          <div class="card-body d-flex justify-content-center">
            <video id="preview"></video>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(() => {

    let scanner = new Instascan.Scanner({video: document.getElementById('preview')});

    scanner.addListener('scan', async function (content) {
      // Kirim hasil scan ke server
      const response = await fetch('@base_url(/hrd/absensi/process-scan)', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          nik: content
        })
      })

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'Terjadi kesalahan');
      }

      const result = await response.json();

      if (result.status === 'success') {
        $('#result-success').css({
          "display": "block"
        });

        $('#nama-karyawan').text(result.karyawan.nama);
        $('#jabatan-karyawan').text(result.karyawan.jabatan);
        $('#message-success').text(result.message);
      } else if (result.status === 'failed') {
        $('#result-failed').css({
          "display": "block"
        });
        $('#message-failed').text(result.message);
      }
      else {
        alert('terjadi kesalahan');
      }


    });

    Instascan.Camera.getCameras().then(function (cameras) {
      if (cameras.length > 0) {
        scanner.start(cameras[0]);
      } else {
        console.error('Kamera tidak ditemukan.');
      }
    });
  });
</script>
@endsection
