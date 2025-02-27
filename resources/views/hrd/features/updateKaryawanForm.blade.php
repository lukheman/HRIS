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
                <div class="card card-danger" id="message-box" style="display: none;">
                  <div class="card-header">
                    <p class="card-title" id="message"></p>
                  </div>
                </div>

              </div>
            </div>

          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="update-form">
            <div class="card-body">

              <input type="hidden" name="old-nik" value="{{ $karyawanOne->nik}}">

              <input type="hidden" name="id" value="{{ $karyawanOne->id}}">

              <div class="form-group">
                <label for="nama">Nama Karyawan</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan nama karyawan"
                  value="{{ $karyawanOne->nama}}" required>
              </div>

              <div class="form-group">
                <label for="nik">NIK Karyawan</label>
                <input type="text" class="form-control" id="nik" name="nik" value="{{ $karyawanOne->nik }}"
                  placeholder="Masukan nik karyawan" required>
              </div>

              <div class="form-group">
                <label for="tanggal-lahir">Tanggal lahir Karyawan</label>
                <input type="date" class="form-control" id="tanggal-lahir" name="tanggal_lahir"
                  value="{{ $karyawanOne->tanggal_lahir }}" placeholder="Tanggal lahir karyawan" required>
              </div>

              <div class="form-group">
                <label for="alamat">Alamat Karyawan</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $karyawanOne->alamat }}"
                  placeholder="Masukan alamat karyawan" required>
              </div>

              <div class="form-group">
                <label for="jabatan">Jabatan Karyawan</label>

                <select name="id_jabatan" id="jabatan" class="form-control" required>
                </select>
              </div>

              <div class="form-group">
                <label for="gaji">Gaji Karyawan</label>
                <input type="text" class="form-control" id="gaji" name="gaji" value="{{ $karyawanOne->gaji }}"
                  placeholder="Masukan Gaji karyawan" required readonly>
              </div>

              <button type="submit" class="btn btn-primary">Update Data</button>

            </div>
            <!-- /.card-body -->

          </form>
        </div>


      </div>
      <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script>
  // action="@base_url(/hrd/karyawan/update)"

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

    $('#jabatan').change(() => {
      // Ambil nilai gaji dari atribut data-gaji pada option yang dipilih
      const gaji = $('#jabatan option:selected').data('gaji');
      // Set nilai gaji ke input
      $('#gaji').val(gaji);
    })


    $('#update-form').on('submit', async function (event) {
      event.preventDefault(); // Mencegah form dari submit standar

      const formData = {};
      $(this).serializeArray().forEach(function (field) {
        formData[field.name] = field.value;
      });


      const response = await fetch('@base_url(/hrd/karyawan/update)', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
      })

      if (!response.ok) {
        throw new Error(errorData.message || 'Terjadi kesalahan');
        Swal.fire("Data gagal diupdate!", "", "danger");
      }

      const data = await response.json();
      console.log(data)

      if (data['status'] === 'success') {
        Swal.fire("Data berhasil diupdate!", "", "success").then(() => {
          window.location.href = '@base_url(/hrd/karyawan)';
        });
      } else if (data['status'] === 'error') {

        $('#message-box').css({'display': 'block'});
        $('#message').text(data['message']);

      }

    });


  })

</script>

@endsection
