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
            <h3 class="text-secondary">generate qr code</h3>

            <!-- TODO: live seearch -->
            <div class="row">
              <div class="col-12">
                <form action="/hrd/absensi/generate-qrcode/search" method="get">
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
                      <td> <a href="/hrd/generateQrCodeProcess" class="btn btn-sm btn-outline-primary">Generate</a></td>
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
            <h3 class="text-secondary">informasi qr code</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
