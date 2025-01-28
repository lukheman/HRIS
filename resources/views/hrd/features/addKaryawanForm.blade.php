@extends('layouts.main')

@section('title', 'HRD')

@section('sidebar-menu')

@include('hrd.menu')

@endsection

@section('content')



<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">

        <div class="card">
          <div class="card-header">
            <!-- <h3 class="card-title">Quick Example</h3> -->
            <div class="row">
              <div class="col-12">

                @if (isset($message))

                <div class="card card-danger">
                  <div class="card-header">
                    <p class="card-title">{{ $message }}</p>
                  </div>
                </div>
                @endif

              </div>
            </div>

          </div>
          <!-- /.card-header -->

          <div class="card-body">
            <!-- form start -->
            <form action="@base_url(/hrd/karyawan/add)" method="post">

              <div class="form-group">
                <label for="nama">Nama Karyawan</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan nama karyawan">
              </div>

              <div class="form-group">
                <label for="nik">NIK Karyawan</label>
                <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukan nik karyawan">
              </div>

              <div class="form-group">
                <label for="tanggal-lahir">Tanggal lahir Karyawan</label>
                <input type="date" class="form-control" id="tanggal-lahir" name="tanggal_lahir"
                  placeholder="Tanggal lahir karyawan">
              </div>

              <div class="form-group">
                <label for="alamat">Alamat Karyawan</label>
                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat karyawan">
              </div>

              <div class="form-group">
                <label for="jabatan">Jabatan Karyawan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan"
                  placeholder="Masukan jabatan karyawan">
              </div>

              <div class="form-group">
                <label for="gaji">Gaji Karyawan</label>
                <input type="text" class="form-control" id="gaji" name="gaji" placeholder="Masukan Gaji karyawan">
              </div>

              <button type="submit" class="btn btn-primary">Tambahkan</button>
            </form>

          </div>
          <!-- /.card-body -->

        </div>
      </div>


    </div>
    <!-- /.col-md-6 -->
  </div>
  <!-- /.row -->
</div><!-- /.container-fluid -->
<!-- /.content -->

@endsection
