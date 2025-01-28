@extends('layouts.main')

@section('title', strtoupper($role))

@section('sidebar-menu')

@include($role .'.menu')

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
                <form action="@base_url(/keuangan/gaji-karyawan)" method="get">

                  <div class="form-group">
                    <label for="periode">Periode</label>
                    <input type="month" class="form-control" name="periode" id="periode">

                  </div>


                  <button type="submit" class="btn btn-primary">Terapkan</button>


                </form>
              </div>
              <div class="col-lg-6">
                <a class="btn btn-primary"
                  href="@base_url(/keuangan/gaji-karyawan/update?periode={{ $periode}})">Refresh
                  Data</a>
                <a class="btn btn-outline-primary float-right"
                  href="@base_url(/keuangan/gaji-karyawan/cetak-slip-gaji-all?periode={{$periode}})">
                  <i class="nav-icon fas fa-print"></i>
                  Slip Gaji Keseluruhan</a>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <h3 class="text-center">{{ $bulan }}</h3>
              </div>

            </div>
          </div>

          <!-- /.card-header -->
          <div class="card-body">
            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4">
              <div class="row">
                <div class="col-lg-12">
                  <table id="" class="table table-bordered table-striped dataTable dtr-inline collapsed"
                    aria-describedby="datatable_info">
                    <thead>
                      <tr>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Periode</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Nama</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Gaji Pokok (Rp)</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Gaji Lembur (Rp)</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Lembur (Menit)</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Total Gaji (Rp)</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Status</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Tindakan</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Checkbox</th>
                      </tr>
                    </thead>
                    <tbody>


                      @foreach ($dataGajiKaryawan as $karyawan)
                      <tr>
                        <td>{{ $karyawan->periode}}</td>
                        <td>{{ $karyawan->nama}}</td>
                        <td>{{ number_format($karyawan->gaji_pokok, 2, ',', '.')}}</td>
                        <td>{{ number_format($karyawan->gaji_lembur, 2, ',', '.')}}</td>
                        <td>{{ $karyawan->total_lembur}}</td>
                        <td>{{ number_format($karyawan->gaji_total, 2, ',', '.')}}</td>

                        <td>
                          <span class="badge bg-warning">{{ $karyawan->status }}</span>
                        </td>
                        <td>
                          <form action="@base_url(/keuangan/gaji-karyawan/cetak-slip-gaji)" method="post">
                            <input type="hidden" name="gaji_id" value="{{ $karyawan->gaji_id }}">
                            <button type="submit" class="btn btn-sm btn-outline-success">
                              <i class="nav-icon fas fa-print"></i>
                              Slip Gaji</button>
                          </form>
                        </td>
                        <td>
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input">
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
@endsection
