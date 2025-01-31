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
                          Tindakan</th>

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
                            <input type="hidden" name="gaji_id" value="{{ $gaji->id_gaji }}">
                            <button type="submit" class="btn btn-sm btn-outline-success w-100" {{$gaji->status !==
                              'DISETUJUI'
                              ? 'disabled' : 'enabled' }}>
                              <i class="nav-icon fas fa-print"></i>
                              Slip Gaji</button>
                          </form>
                        </td>

                        <!-- <td> -->
                        <!--   <div class="btn-group"> -->
                        <!---->
                        <!--     <button type="button" class="btn btn-sm btn-danger btn-delete-laporan" -->
                        <!--       data-id="{{ $gaji->id_gaji }}"> -->
                        <!--       <i class="nav-icon fas fa-trash"></i> -->
                        <!--     </button> -->
                        <!---->
                        <!--     <button type="button" class="btn btn-sm btn-success btn-approve-laporan" -->
                        <!--       data-id="{{ $gaji->id_gaji }}"> -->
                        <!--       <i class="nav-icon fas fa-check"></i> -->
                        <!--     </button> -->
                        <!---->
                        <!--     <button type="button" class="btn btn-sm btn-warning btn-pending-laporan" -->
                        <!--       data-id="{{ $gaji->id_gaji }}"> -->
                        <!--       <i class="nav-icon fas fa-times"></i> -->
                        <!--     </button> -->
                        <!---->
                        <!--   </div> -->
                        <!-- </td> -->
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
              <!-- <div class="row"> -->
              <!--   <div class="col-sm-12 col-md-5"> -->
              <!--     <div class="dataTables_info" id="datatable_info" role="status" aria-live="polite">Showing 1 to 10 of 57 -->
              <!--       entries</div> -->
              <!--   </div> -->
              <!--   <div class="col-sm-12 col-md-7"> -->
              <!--     <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate"> -->
              <!--       <ul class="pagination"> -->
              <!--         <li class="paginate_button page-item previous disabled" id="datatable_previous"><a href="#" -->
              <!--             aria-controls="datatable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li> -->
              <!--         <li class="paginate_button page-item active"><a href="#" aria-controls="datatable" data-dt-idx="1" -->
              <!--             tabindex="0" class="page-link">1</a></li> -->
              <!--         <li class="paginate_button page-item "><a href="#" aria-controls="datatable" data-dt-idx="2" -->
              <!--             tabindex="0" class="page-link">2</a></li> -->
              <!--         <li class="paginate_button page-item "><a href="#" aria-controls="datatable" data-dt-idx="3" -->
              <!--             tabindex="0" class="page-link">3</a></li> -->
              <!--         <li class="paginate_button page-item "><a href="#" aria-controls="datatable" data-dt-idx="4" -->
              <!--             tabindex="0" class="page-link">4</a></li> -->
              <!--         <li class="paginate_button page-item "><a href="#" aria-controls="datatable" data-dt-idx="5" -->
              <!--             tabindex="0" class="page-link">5</a></li> -->
              <!--         <li class="paginate_button page-item "><a href="#" aria-controls="datatable" data-dt-idx="6" -->
              <!--             tabindex="0" class="page-link">6</a></li> -->
              <!--         <li class="paginate_button page-item next" id="datatable_next"><a href="#" aria-controls="datatable" -->
              <!--             data-dt-idx="7" tabindex="0" class="page-link">Next</a></li> -->
              <!--       </ul> -->
              <!--     </div> -->
              <!--   </div> -->
              <!-- </div> -->
            </div>
          </div>
          <!-- /.card-body -->
        </div>

      </div>
      <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
  <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Laporan Gaji</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="@base_url(/{{$role}}/gaji-karyawan/add)" method="post">
          <div class="modal-body">

            <input type="hidden" name="id" value="{{ $idKaryawan }}">

            <div class="form-group">
              <label for="durasi-lembur">Durasi Lembur (Jam)</label>
              <input type="number" class="form-control" id="durasi-lembur" name="durasi_lembur"
                placeholder="Total Durasi Lembur" min="0">
            </div>

            <div class="form-group">
              <label for="gaji-lembur">Gaji Lembur</label>
              <input type="number" class="form-control" id="gaji-lembur" name="gaji_lembur" placeholder="Gaji Lembur"
                min="0">
            </div>

            <div class="form-group">
              <label for="periode">Periode (Tahun-Bulan)</label>
              <input type="month" class="form-control" id="periode" name="periode" placeholder="periode" required>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Tambahkan</button>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
<!-- /.content -->

<script>

  $(document).ready(() => {

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
              Swal.fire("Gaji berhasil dipending!", "", "success").then(() =>
                location.reload());
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
