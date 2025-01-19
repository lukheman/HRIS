@extends('layouts.main')

@section('title', 'Generate Qr Code')

@section('sidebar-menu')

@include('hrd.menu')

@endsection

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">

          </div>
          <div class="card-body">
            <!-- <h3 class="text-secondary"></h3> -->

            <!-- TODO: live seearch -->
            <div class="row">
              <div class="col-12">
                <form action="@base_url(/hrd/absensi/generate-qrcode/search)" method="get">
                  <div class="input-group">
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan nama karyawan">
                    <span class="input-group-append">
                      <button type="submit" class="btn btn-primary">Cari Karyawan</button>

                    </span>
                  </div>
                </form>
              </div>
              <div class="col-12">

                @if (isset($listKaryawan))

                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>NIK</th>
                      <th style="width: 40px">Tindakan</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($listKaryawan as $karyawan)
                    <tr>
                      <td>{{ $karyawan->nama }}</td>
                      <td>{{ $karyawan->nik }}</td>
                      <td>
                        <button class="btn btn-outline-primary btn-sm btn-generate"
                          value="{{ $karyawan->nik }}">Generate</button>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                @endif

              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">

          </div>
          <div class="card-body">
            <!-- <h3 class="text-secondary">informasi qr code</h3> -->
            <div class="row">
              <div class="col-12">
                <img class="img-fluid" src="" id="qrcode">
              </div>
              <div class="col-12">
                <form action="@base_url(/hrd/absensi/generate-qrcode/save)" method="post">
                  <input type="hidden" value="" name="nik" id="nik-karyawan">
                  <button type="submit" class="btn btn-outline-primary" style="display: none;"
                    id="btn-cetak-qrcode">Cetak QR Code</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

  document.addEventListener('DOMContentLoaded', () => {
    let qrcode = document.getElementById('qrcode');

    let btnGenerates = document.getElementsByClassName('btn-generate');
    let nikKaryawan = document.getElementById('nik-karyawan');
    let btnCetakQrCode = document.getElementById('btn-cetak-qrcode');

    Array.from(btnGenerates).forEach(btn => {
      btn.addEventListener('click', async () => {
        try {
          const response = await fetch('@base_url(/hrd/absensi/generate-qrcode/generate)', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              nik: btn.value
            })
          });

          if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Terjadi kesalahan');
          }

          const blob = await response.blob();
          const qrCodeUrl = URL.createObjectURL(blob);

          qrcode.src = qrCodeUrl;

          nikKaryawan.value = btn.value;
          btnCetakQrCode.style.display = 'block';

        } catch (error) {
          console.error('Error:', error);
          alert('Gagal generate QR Code: ' + error.message);
        }
      });
    });


  });


  // TODO: gunakan jquery untuk melakuakn dom
</script>
@endsection
