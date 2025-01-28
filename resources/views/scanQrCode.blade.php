<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FBS | @yield('title', 'Default Title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="@base_url(/plugins/fontawesome-free/css/all.min.css)">
  <!-- Theme style -->
  <link rel="stylesheet" href="@base_url(/assets/css/adminlte.min.css)">
</head>

<body>

  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <h1 class="text-center">Perlihatkan ID Card Anda</h1>

        </div>
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

  <!-- jQuery -->
  <script src="@base_url(/plugins/jquery/jquery.min.js)"></script>
  <!-- Bootstrap 4 -->
  <script src="@base_url(/plugins/bootstrap/js/bootstrap.bundle.min.js)"></script>
  <!-- AdminLTE App -->
  <script src="@base_url(/assets/js/adminlte.min.js)"></script>

  <!-- instascan/camera -->
  <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

  <script>
    $(document).ready(() => {

      let scanner = new Instascan.Scanner({video: document.getElementById('preview')});

      scanner.addListener('scan', async function (content) {
        // Kirim hasil scan ke server
        const response = await fetch('@base_url(/absensi/process-scan)', {
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

</body>

</html>
