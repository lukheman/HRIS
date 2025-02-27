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
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan nama karyawan"
                  required>
              </div>

              <div class="form-group">
                <label for="nik">NIK Karyawan</label>
                <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukan nik karyawan" required>
              </div>

              <div class="form-group">
                <label for="tanggal-lahir">Tanggal lahir Karyawan</label>
                <input type="date" class="form-control" id="tanggal-lahir" name="tanggal_lahir"
                  placeholder="Tanggal lahir karyawan" required>
              </div>

              <div class="form-group">
                <label for="alamat">Alamat Karyawan</label>
                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat karyawan">
              </div>

              <div class="form-group">
                <label for="jabatan">Jabatan Karyawan</label>

                <select name="id_jabatan" id="jabatan" class="form-control" required>
                  <!-- <option>Pilih Jabatan</option> -->
                </select>

              </div>

              <div class="form-group">
                <label for="gaji">Gaji Karyawan</label>
                <input type="text" class="form-control" id="gaji" name="gaji" placeholder="Masukan Gaji karyawan"
                  required readonly>
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


<script>

  $(document).ready(() => {

    $.ajax({
      url: '@base_url(/api/get-jabatan)',
      type: 'GET',
      success: (response) => {
        if (response.status === 'success') {
          response.data.forEach(jabatan => {
            $('#jabatan').append(`<option value="${jabatan.id}" data-gaji="${jabatan.gaji}">${jabatan.jabatan}</option>`)
          })
        }
      },
      error: function (xhr, status, error) {
      }
    })
  })

  $('#jabatan').change(() => {
    // Ambil nilai gaji dari atribut data-gaji pada option yang dipilih
    const gaji = $('#jabatan option:selected').data('gaji');
    // Set nilai gaji ke input
    $('#gaji').val(gaji);
  })

</script>
@endsection
