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

            <div class="row">
              <div class="col-6">
                <button type="button" class="btn btn-primary" id="btn-update-gaji">
                  <i class="nav-icon fas fa-sync"></i>
                  Perbarui Laporan Gaji</button>
                @if (isset($idKaryawan))
                @else
                <!-- <a class="btn btn-outline-primary" -->
                <!--   href="@base_url(/{{ $role }}/gaji-karyawan/cetak-slip-gaji-all?periode=all)"> -->
                <!--   <i class="nav-icon fas fa-print"></i> -->
                <!--   Slip Gaji Keseluruhan</a> -->
                @endif
              </div>
              <div class="col-6">
                <p class="font-weight-bold float-right">{{ $namaKaryawan }}</p>
              </div>
            </div>
          </div>

          <!-- /.card-header -->
          <div class="card-body">
            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <!--<div class="col-12">-->
                <!--  <button type="button" class="btn btn-outline-info float-right">Pilih</button>-->
                <!--</div>-->
                <div class="col-12">
                  <table id="datatable" class="table table-bordered table-striped dataTable dtr-inline collapsed"
                    aria-describedby="datatable_info">
                    <thead>
                      <tr>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Periode</th>
                        @if (!isset($idKaryawan))
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Nama</th>
                        @endif
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Gaji Pokok (Rp.)</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Gaji Lembur (Rp.)</th>
                        <th style="width: 15%;" class="sorting" tabindex="0" aria-controls="datatable" rowspan="1"
                          colspan="1">
                          Total Durasi Lembur (Jam)</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Total Gaji (Rp.)</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Status</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Slip Gaji</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Tindakan</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Pilih</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach ($dataGajiKaryawan as $gaji)
                      <tr>
                        <td>{{ $gaji->periode}}</td>
                        @if (!isset($idKaryawan))
                        <td>{{ $gaji->nama}}</td>
                        @endif
                        <td>{{ number_format($gaji->gaji_pokok, 2, ',', '.')}}</td>
                        <td>{{ number_format($gaji->gaji_lembur, 2, ',', '.')}}</td>
                        <td>{{ $gaji->total_lembur}}</td>
                        <td>{{ number_format($gaji->gaji_total, 2, ',', '.')}}</td>
                        <td>
                          @if ($gaji->status === 'PENDING')
                          <span class="badge bg-warning">{{ $gaji->status }}</span>
                          @elseif ($gaji->status === 'DISETUJUI')
                          <span class="badge bg-success">{{ $gaji->status }}</span>
                          @elseif ($gaji->status === 'DITOLAK')
                          <span class="badge bg-danger">{{ $gaji->status }}</span>
                          @endif
                        </td>
                        <td>
                          <form action="@base_url(/{{ $role }}/gaji-karyawan/cetak-slip-gaji)" method="post">
                            <input type="hidden" name="id_gaji" value="{{ $gaji->id_gaji }}">
                            <button type="submit" class="btn btn-sm btn-outline-success w-100" {{$gaji->status !==
                              'DISETUJUI'
                              ? 'disabled' : 'enabled' }}>
                              <i class="nav-icon fas fa-print"></i>
                            </button>
                          </form>
                        </td>
                        <td>
                          <div class="btn-group w-100">

                            <button type="button" class="btn btn-sm btn-danger btn-delete-laporan"
                              data-id="{{ $gaji->id_gaji }}">
                              <i class="nav-icon fas fa-trash"></i>
                            </button>

                            <button type="button" class="btn btn-sm btn-success btn-approve-laporan"
                              data-id="{{ $gaji->id_gaji }}">
                              <i class="nav-icon fas fa-check"></i>
                            </button>

                            <button type="button" class="btn btn-sm btn-warning btn-pending-laporan"
                              data-id="{{ $gaji->id_gaji }}">
                              <i class="nav-icon fas fa-times"></i>
                            </button>
                          </div>

                        </td>

                        <td>
                          <input type="checkbox" class="select-laporan" data-id="{{ $gaji->id_gaji }}">
                        </td>

                      </tr>
                      @endforeach



                    </tbody>

                    <!-- <tfoot> -->
                    <!--   <tr> -->
                    <!--     <th rowspan="1" colspan="1">Rendering engine</th> -->
                    <!--     <th rowspan="1" colspan="1">Browser</th> -->
                    <!--     <th rowspan="1" colspan="1">Platform(s)</th> -->
                    <!--     <th rowspan="1" colspan="1">Engine version</th> -->
                    <!--     <th rowspan="1" colspan="1" style="display: none;">CSS grade</th> -->
                    <!--   </tr> -->
                    <!-- </tfoot> -->

                  </table>
                </div>
              </div>


            </div>
          </div>
          <!-- /.card-body -->
        </div>

      </div>


    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Fixed Box -->
<div class="fixed-box" id="action-box" style="display: none;">
  <div class="btn-group float-right">
    <button class="btn btn-success btn-sm" id="btn-setujui-selected">
      <i class="nav-icon fas fa-check"></i>
      Setujui</button>
    <button class="btn btn-warning btn-sm" id="btn-pending-selected">
      <i class="nav-icon fas fa-times"></i>
      Pending</button>
  </div>
</div>


<script>

  $(document).ready(() => {

    $('#btn-update-gaji').click(() => {

      $.ajax({
        url: '@base_url(/{{ $role }}/gaji-karyawan/update)',
        type: 'POST',
        success: function (response) {
          if (response.status === 'success') {
            Swal.fire("Laporan gaji berhasil diupdate", "", "success").then(() => location.reload());
          }
        },
        error: function (xhr, status, error) {
          // Tampilkan pesan error
          console.error("Terjadi kesalahan:", error);
          Swal.fire("Laporan gaji gagal diupdate", "", "error");
        },
      });

    });

    $('.select-laporan').click(() => {
      if ($('#action-box').css('display') === 'none') {
        $('#action-box').css('display', 'block');
      }
    })

    $('#btn-setujui-selected').click(() => {

      var selected = [];

      $('.select-laporan:checked').each(function () {
        selected.push($(this).data('id'));
      });

      $.ajax({
        url: '@base_url(/{{ $role }}/gaji-karyawan/approve-selected)',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({'selected_id': selected}),
        success: function (response) {
          Swal.fire("Laporan gaji berhasil diupdate", "", "success").then(() => location.reload());
        },
        error: function (xhr, status, error) {
          // Tampilkan pesan error
          console.error("Terjadi kesalahan:", error);
          Swal.fire("Laporan gaji gagal diupdate", "", "danger");
        },
      });

    })

    $('#btn-pending-selected').click(() => {
      var selected = [];

      $('.select-laporan:checked').each(function () {
        selected.push($(this).data('id'));
      });

      $.ajax({
        url: '@base_url(/{{ $role }}/gaji-karyawan/pending-selected)',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({'selected_id': selected}),
        success: function (response) {
          Swal.fire("Laporan gaji berhasil diupdate", "", "success").then(() => location.reload());
        },
        error: function (xhr, status, error) {
          // Tampilkan pesan error
          console.error("Terjadi kesalahan:", error);
          Swal.fire("Laporan gaji gagal diupdate", "", "danger");
        },
      });

    })

    // btn-delete handler
    $(".btn-delete-laporan").on('click', async function () {

      Swal.fire({
        customClass: {
          confirmButton: "btn btn-danger",
          // cancelButton: "btn btn-danger"
        },
        title: "Anda yakin untuk menghapus data laporan?",
        // text: "Proses ini akan menghapus semua data absensi dan gaji karyawan!",
        // showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Hapus Data",
        // denyButtonText: `Don't save`
      }).then(async (result) => {
        if (result.isConfirmed) {
          try {
            const response = await fetch('@base_url(/{{ $role }}/gaji-karyawan/delete)', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({
                id: $(this).data('id')
              })
            })
            if (!response.ok) {
              const errorData = await response.json();
              throw new Error(errorData.message || 'Terjadi kesalahan');
            }

            if (!response.ok) {
              throw new Error(errorData.message || 'Terjadi kesalahan');
              Swal.fire("Data gagal dihapus!", "", "danger");
            } else {
              Swal.fire("Data berhasil dihapus!", "", "success").then(() =>
                location.reload());
            }

          } catch (error) {
            console.error('Error:', error);
          }

        }
      });


    });

    // btn-approve-laporan handler
    $(".btn-approve-laporan").click(async function () {

      Swal.fire({
        customClass: {
          confirmButton: "btn btn-success",
          // cancelButton: "btn btn-danger"
        },
        title: "Setujui laporan gaji?",
        // text: "Proses ini akan menghapus semua data absensi dan gaji karyawan!",
        // showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Terima gaji",
        // denyButtonText: `Don't save`
      }).then(async (result) => {
        if (result.isConfirmed) {
          try {
            const response = await fetch('@base_url(/{{ $role }}/gaji-karyawan/approve)', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({
                id: $(this).data('id')
              })
            })
            if (!response.ok) {
              const errorData = await response.json();
              throw new Error(errorData.message || 'Terjadi kesalahan');
            }

            if (!response.ok) {
              throw new Error(errorData.message || 'Terjadi kesalahan');
              Swal.fire("Gaji gagal disetujii!", "", "danger");
            } else {
              Swal.fire("Gaji berhasil disetujui!", "", "success").then(() =>
                location.reload());
            }

          } catch (error) {
            console.error('Error:', error);
          }

        }
      });

    })

    // btn-approve-laporan handler
    $(".btn-pending-laporan").click(async function () {

      Swal.fire({
        customClass: {
          confirmButton: "btn btn-warning",
          // cancelButton: "btn btn-danger"
        },
        title: "Pending laporan gaji?",
        // text: "Proses ini akan menghapus semua data absensi dan gaji karyawan!",
        // showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Pending gaji",
        // denyButtonText: `Don't save`
      }).then(async (result) => {
        if (result.isConfirmed) {
          try {
            const response = await fetch('@base_url(/{{ $role }}/gaji-karyawan/pending)', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({
                id: $(this).data('id')
              })
            })
            if (!response.ok) {
              const errorData = await response.json();
              throw new Error(errorData.message || 'Terjadi kesalahan');
            }

            if (!response.ok) {
              throw new Error(errorData.message || 'Terjadi kesalahan');
              Swal.fire("Gaji gagal dipending!", "", "danger");
            } else {
              Swal.fire("Gaji berhasil dipending!", "", "success").then(() => location.reload());
            }

          } catch (error) {
            console.error('Error:', error);
          }

        }
      });

    })





  })

</script>

@endsection
