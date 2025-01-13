@extends('layouts.main')

@section('title', 'HRD')

@section('sidebar-menu')

@include('hrd.menu')

@endsection

@section('content')



<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Tambahkan Karyawan Baru</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Starter Page</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">

        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Quick Example</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="/hrd/karyawan/add" method="post">
            <div class="card-body">

              <div class="form-group">
                <label for="nama">Nama Karyawan</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan nama karyawan">
              </div>

              <div class="form-group">
                <label for="nik">Nik Karyawan</label>
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


            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>


      </div>
      <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

@endsection
