@extends('layouts.main')

@section('title', strtoupper($role))

@section('sidebar-menu')

@include($role . '.menu')

@endsection

@section('content')

<!-- TODO: tambahkan pageination -->

<div class="content">
  <div class="contaier-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-12">
                <div class="btn-group">
                  <a class="btn btn-primary {{ $by === 'all' ? 'disabled' : 'active' }}"
                    href="@base_url(/{{$role }}/absensi/all)"> <i class="nav-icon fas fa-border-all"></i>
                    Semua</a>
                  <a href="@base_url(/{{$role}}/absensi/all?by=day)"
                    class="btn btn-primary {{ $by === 'day' ? 'disabled' : 'active' }}">
                    <i class="nav-icon fas fa-calendar-day"></i>
                    Hari Ini</a>
                  <a class="btn btn-primary {{ $by === 'month' ? 'disabled' : 'active' }}"
                    href="@base_url(/{{$role }}/absensi/all?by=month)">
                    <i class="nav-icon fas fa-calendar"></i>
                    Bulan Ini</a>
                </div>
                <button type="button" class="btn btn-outline-primary" id="btn-print-absensi" data-toggle="modal"
                  data-target="#modal-laporan-absensi">
                  <i class="nav-icon fas fa-print"></i>
                  Cetak Laporan Absensi</button>
              </div>
            </div>

          </div>
          <div class="card-body">
            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-12">
                  <table id="datatable" class="table table-bordered table-stripped dataTable dtr-inline collapsed"
                    aria-describedby="datatable_info">
                    <thead>
                      <tr>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Nama</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Tanggal</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Jam Masuk</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Jam Keluar</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Lembur (Jam)</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Status</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Tindakan</th>
                      </tr>

                    </thead>
                    <tbody>

                      @foreach ($data_absensi as $absensi)
                      <tr>
                        <td>{{ $absensi->nama}}</td>
                        <td>{{ $absensi->tanggal}}</td>
                        <td>{{ $absensi->jam_masuk}}</td>
                        <td>{{ $absensi->jam_keluar}}</td>
                        <td>{{ $absensi->lembur}}</td>
                        <td>
                          @if ($absensi->status === 'Hadir')
                          <span class="badge bg-success">{{ $absensi->status }}</span>
                          @elseif ($absensi->status === 'Alpha')
                          <span class="badge bg-danger">{{ $absensi->status }}</span>
                          @endif
                        </td>
                        <td>


                          <div class="btn-group">

                            <a href="@base_url(/{{ $role }}/absensi/detail?id={{ $absensi->karyawan_id }}&periode={{ date('Y-m')}})"
                              class="btn btn-sm btn-outline-primary">
                              <i class="nav-icon fas fa-calendar-alt"></i> Detail
                            </a>

                            <!-- <a href="@base_url(/{{ $role }}/absensi/update?id_absensi={{ $absensi->id }})" -->
                            <!--   class="btn btn-sm btn-outline-primary"> -->
                            <!--   <i class="nav-icon fas fa-pencil-alt"></i> Edit -->
                            <!-- </a> -->

                            <button type="button" class="btn btn-sm btn-outline-primary btn-edit" data-toggle="modal"
                              data-target="#modal-input-lembur" data-id="{{ $absensi->id_absensi }}">
                              <i class="nav-icon fas fa-pencil-alt"></i> Edit
                            </button>

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
        </div>
      </div>
    </div>
  </div>
</div>

<!-- modal edit absensi harian. digunakan untuk menambahkan durasi lembur karyawan -->
<div class="modal fade" id="modal-input-lembur" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Absensi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form>
        <div class="modal-body">

          <input type="hidden" name="id_absensi">

          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" placeholder="Nama" name="nama" disabled>
          </div>

          <div class="form-group">
            <label for="lembur">Durasi Lembur (Jam)</label>
            <input type="number" class="form-control" id="lembur" placeholder="Lembur" min="0" name="durasi_lembur">
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button class="btn btn-primary" type="submit" id="btn-submit">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- modal print laporan absensi -->
<div class="modal fade" id="modal-laporan-absensi" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cetak Laporan Absensi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="@base_url(/{{ $role }}/absensi/cetak-laporan-absensi)" method="post">
        <div class="modal-body">

          <div class="form-group">
            <label>Nama Karyawan</label>
            <select class="form-control" name="id_karyawan" id="list-karyawan">
              <option value="all" selected>Semua Karyawan</option>
            </select>
          </div>

          <div class="form-group">
            <label for="periode">Periode</label>
            <input type="month" class="form-control" id="periode" name="periode" required>
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

<script>

  $(document).ready(() => {

    $('#btn-print-absensi').click(() => {
      $.ajax({
        url: '@base_url(/api/get-karyawan-all)',
        type: 'GET',
        success: function (response) {
          // Swal.fire("Laporan gaji berhasil diupdate", "", "success").then(() => location.reload());
          if (response.status === 'success') {
            response.data.forEach(karyawan => {
              $('#list-karyawan').append(`<option value="${karyawan.id}">${karyawan.nama} - ${karyawan.nik}</option>`)
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


    $('.btn-edit').click(async function () {

      var row = $(this).closest("tr");

      // Ambil nama dari kolom pertama di baris tersebut
      var nama = row.find("td:first").text();

      // Opsional: Isi input di modal dengan nama yang diambil
      $("#modal-input-lembur input[name='nama']").val(nama);
      $("#modal-input-lembur input[name='id_absensi']").val($(this).data('id'));

    })

    $('#btn-submit').click(function (e) {
      e.preventDefault();

      let id_absensi = $("#modal-input-lembur input[name='id_absensi']").val();
      let durasi_lembur = $("#modal-input-lembur input[name='durasi_lembur']").val();

      $.ajax({
        url: '@base_url(/{{ $role }}/absensi/update)',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({id_absensi: id_absensi, durasi_lembur: durasi_lembur}),
        success: function (response) {
          Swal.fire("Data absensi berhasil diupdate", "", "success").then(() => location.reload());
        },
        error: function (xhr, status, error) {
          // Tampilkan pesan error
          console.error("Terjadi kesalahan:", error);
          Swal.fire("Data absensi gagal diupdate", "", "danger");
        },
      })

    })

  })
</script>
@endsection
