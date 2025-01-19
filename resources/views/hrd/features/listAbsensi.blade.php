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
              <div class="col-12">

                <div class="btn-group">
                  <a href="@base_url(/hrd/absensi/all?by=day)"
                    class="btn btn-primary {{ $by === 'day' ? 'disabled' : 'active' }}">
                    <i class="nav-icon fas fa-calendar-day"></i>
                    Hari Ini</a>
                  <a class="btn btn-primary {{ $by === 'month' ? 'disabled' : 'active' }}"
                    href="@base_url(/hrd/absensi/all?by=month)"> <i class="nav-icon fas fa-calendar-week"></i>
                    Bulan Ini</a>
                </div>

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
                          Tanggal</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Jam Masuk</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Jam Keluar</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Lembur (menit)</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Status</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Tindakan</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach ($data_absensi as $karyawan)
                      <tr>
                        <td>{{ $karyawan->nama}}</td>
                        <td>{{ $karyawan->tanggal}}</td>
                        <td>{{ $karyawan->jam_masuk}}</td>
                        <td>{{ $karyawan->jam_keluar}}</td>
                        <td>{{ $karyawan->lembur}}</td>
                        <td>{{ $karyawan->status}}</td>
                        <td>
                          <form action="@base_url(/hrd/absensi/detail)" method="get">
                            <input type="hidden" name="id" value="{{ $karyawan->karyawan_id}}">
                            <input type="hidden" name="periode" value="2025-01">

                            <button type="submit" class="btn btn-sm btn-outline-primary">
                              <i class="nav-icon fas fa-calendar-alt"></i>
                              Detail</button>
                          </form>

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
@endsection
