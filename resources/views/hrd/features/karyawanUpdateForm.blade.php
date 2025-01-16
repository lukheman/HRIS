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

        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Quick Example</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="/hrd/karyawan/update" method="post">
            <div class="card-body">

              <input type="hidden" name="id" value="{{ $karyawanOne->id }}">

              <div class="form-group">
                <label for="nama">Nama Karyawan</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan nama karyawan"
                  value="{{ $karyawanOne->nama}}">
              </div>

              <div class="form-group">
                <label for="nik">Nik Karyawan</label>
                <input type="text" class="form-control" id="nik" name="nik" value="{{ $karyawanOne->nik }}"
                  placeholder="Masukan nik karyawan">
              </div>

              <div class="form-group">
                <label for="tanggal-lahir">Tanggal lahir Karyawan</label>
                <input type="date" class="form-control" id="tanggal-lahir" name="tanggal_lahir"
                  value="{{ $karyawanOne->tanggal_lahir }}" placeholder="Tanggal lahir karyawan">
              </div>

              <div class="form-group">
                <label for="alamat">Alamat Karyawan</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $karyawanOne->alamat }}"
                  placeholder="Masukan alamat karyawan">
              </div>

              <div class="form-group">
                <label for="jabatan">Jabatan Karyawan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $karyawanOne->jabatan }}"
                  placeholder="Masukan jabatan karyawan">
              </div>

              <div class="form-group">
                <label for="gaji">Gaji Karyawan</label>
                <input type="text" class="form-control" id="gaji" name="gaji" value="{{ $karyawanOne->gaji }}"
                  placeholder="Masukan Gaji karyawan">
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
