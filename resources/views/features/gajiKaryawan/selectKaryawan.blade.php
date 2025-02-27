@extends('layouts.main')

@section('title', strtoupper($role))

@section('sidebar-menu')

@include($role . '.menu')

@endsection

@section('content')


<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">

        <div class="card">
          <div class="card-header">

            <div class="col-12">


              <a class="btn btn-outline-primary " href="@base_url(/{{ $role }}/gaji-karyawan/detail?id=all)">
                <i class="nav-icon fas fa-eye"></i>
                Semua Karyawan</a>

              <button type="button" class="btn btn-outline-primary" id="btn-laporan-gaji" data-toggle="modal"
                data-target="#modal-laporan-gaji">
                <i class="nav-icon fas fa-print"></i>
                Cetak Laporan Gaji</button>

            </div>

          </div>

          <!-- /.card-header -->
          <div class="card-body">
            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-lg-12">
                  <table id="datatable" class="table table-bordered table-striped dataTable dtr-inline collapsed"
                    aria-describedby="datatable_info">
                    <thead>
                      <tr>

                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Nama</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          NIK</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Tanggal Lahir</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Alamat</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Jabatan</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Gaji</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Tindakan</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach ($data_karyawan as $karyawan)
                      <tr>
                        <td>{{ $karyawan->nama}}</td>
                        <td>{{ $karyawan->nik}}</td>
                        <td>{{ $karyawan->tanggal_lahir}}</td>
                        <td>{{ $karyawan->alamat}}</td>
                        <td>{{ $karyawan->jabatan}}</td>
                        <td>{{ number_format($karyawan->gaji, 0, ',', '.')}}</td>
                        <td>

                          <a href="@base_url(/{{ $role }}/gaji-karyawan/detail?id={{ $karyawan->id_karyawan }})"
                            class="btn btn-sm btn-outline-primary">
                            <i class="nav-icon fas fa-eye"></i>
                            Lihat</a>

                        </td>

                      </tr>
                      @endforeach


                    </tbody>

                  </table>
                </div>
              </div>

            </div>
            <!-- /.col-md-6 -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

      <!-- modal print laporan gaji -->
      <div class="modal fade" id="modal-laporan-gaji" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Cetak Laporan Gaji</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <form action="@base_url(/{{ $role }}/gaji-karyawan/cetak-laporan-gaji)" method="post">
              <div class="modal-body">

                <div class="form-group">
                  <label>Nama Karyawan</label>
                  <select class="form-control" name="id_karyawan" id="list-karyawan">
                    <option value="all" selected>Semua Karyawan</option>
                  </select>
                </div>

                <div class="row">
                  <div class="col-6">

                    <div class="form-group">
                      <label for="start-date">Awal</label>
                      <input type="month" class="form-control" id="start-date" name="start-date" required>
                    </div>

                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label for="end-date">Akhir</label>
                      <input type="month" class="form-control" id="end-date" name="end-date" required>
                    </div>
                  </div>

                </div>



              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Cetak</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.content -->

      <script>
        $(document).ready(() => {

          $('#btn-laporan-gaji').click(() => {
            $.ajax({
              url: '@base_url(/api/get-karyawan-all)',
              type: 'GET',
              success: function (response) {
                if (response.status === 'success') {
                  response.data.forEach(karyawan => {
                    $('#list-karyawan').append(`<option value="${karyawan.id_karyawan}">${karyawan.nama} - ${karyawan.nik}</option>`)
                  })
                }
              },
              error: function (xhr, status, error) {
                // Tampilkan pesan error
                console.error("Terjadi kesalahan:", error);
                Swal.fire("Laporan gaji gagal diupdate", "", "danger");
              },
            })
          })

          $('.btn-delete').on('click', function () {

            const id = $(this).data('id');

            Swal.fire({
              customClass: {
                confirmButton: "btn btn-danger",
                // cancelButton: "btn btn-danger"
              },
              title: "Anda yakin untuk menghapus data karyawan?",
              text: "Proses ini akan menghapus semua data absensi dan gaji karyawan!",
              // showDenyButton: true,
              showCancelButton: true,
              confirmButtonText: "Hapus Data",
              // denyButtonText: `Don't save`
            }).then(async (result) => {
              if (result.isConfirmed) {
                console.log(id);
                const response = await fetch('@base_url(/{{$role}}/karyawan/delete)', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                  },
                  body: JSON.stringify({
                    id: id
                  })
                })

                if (!response.ok) {
                  throw new Error(errorData.message || 'Terjadi kesalahan');
                  Swal.fire("Data gagal dihapus!", "", "danger");
                } else {
                  Swal.fire("Data berhasil dihapus!", "", "success").then(() =>
                    location.reload());
                }
              }
            });

          })

        })
      </script>
      @endsection
