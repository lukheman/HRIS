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

            <div class="row">
              <div class="col-lg-6">
                <a class="btn btn-primary float-end" href="@base_url(/hrd/karyawan/add)">
                  <i class="nav-icon fas fa-plus"></i>
                  Tambah Karyawan</a>
              </div>
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
                        <td>{{ number_format($karyawan->gaji, 0, ',', '.') }}</td>
                        <td>
                          <div class="btn-group">
                            <a href="@base_url(/{{ $role }}/karyawan/update?id={{ $karyawan->id_karyawan }})" class="btn btn-sm
                            btn-outline-primary">
                              <i class="nav-icon fas fa-pencil-alt"></i>
                              Edit
                            </a>
                            <button type="submit" class="btn btn-sm btn-outline-danger btn-delete"
                              data-id="{{ $karyawan->id}}">
                              <i class="nav-icon fas fa-trash"></i> Hapus</button>
                          </div>
                        </td>

                      </tr>
                      @endforeach



                    </tbody>

                  </table>
                </div>
              </div>

            </div>
          </div>
          <!-- /.card-body -->
        </div>

      </div>
      <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script>
  $(document).ready(() => {


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
          const response = await fetch('@base_url(/hrd/karyawan/delete)', {
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
