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
              <div class="col-lg-6">
                <form action="@base_url(/keuangan/gaji-karyawan)" method="get">

                  <!-- <div class="form-group"> -->
                  <!--   <label for="tahun">Tahun</label> -->
                  <!--   <input class="form-control" type="number" id="tahun" name="tahun" min="1900" max="2100" -->
                  <!--     placeholder="2025" value="2025"> -->
                  <!-- </div> -->
                  <!---->
                  <!-- <div class="form-group"> -->
                  <!--   <label for="bulan">Bulan</label> -->
                  <!--   <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" id="bulan" -->
                  <!--     name="bulan"> -->
                  <!--     <option value="01">Januari</option> -->
                  <!--     <option value="02">Februari</option> -->
                  <!--     <option value="03">Maret</option> -->
                  <!--     <option value="04">April</option> -->
                  <!--     <option value="05">Mei</option> -->
                  <!--     <option value="06">Juni</option> -->
                  <!--     <option value="07">Juli</option> -->
                  <!--     <option value="08">Agustus</option> -->
                  <!--     <option value="09">September</option> -->
                  <!--     <option value="10">Oktober</option> -->
                  <!--     <option value="11">November</option> -->
                  <!--     <option value="12">Desember</option> -->
                  <!--   </select> -->
                  <!---->
                  <!-- </div> -->

                  <div class="form-group">
                    <label for="periode">Periode</label>
                    <input type="month" class="form-control" name="periode" id="periode">

                  </div>


                  <button type="submit" class="btn btn-primary">Terapkan</button>


                </form>
              </div>

              <div class="col-lg-6">
                <!-- <a class="btn btn-primary" -->
                <!--   href="@base_url(/keuangan/gaji-karyawan/update?periode={{ $periode}})">Refresh -->
                <!--   Data</a> -->
                <!-- <a class="btn btn-outline-primary float-right" -->
                <!--   href="@base_url(/keuangan/gaji-karyawan/cetak-slip-gaji-all?periode={{$periode}})"> -->
                <!--   <i class="nav-icon fas fa-print"></i> -->
                <!--   Slip Gaji Keseluruhan</a> -->

                <a href="" class="btn btn-primary">Tambah Laporan Gaji</a>
              </div>

            </div>
          </div>

          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">

              <div class="col-lg-12">
                <h3 class="text-center">{{ $bulan }}</h3>
              </div>

            </div>
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
                          Gaji Kerja (Rp)</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Gaji Lembur (Rp)</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Lembur (Menit)</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Total Gaji (Rp)</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Tindakan</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Status</th>
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

                          <button class="btn btn-sm btn-success">Update</button>

                        </td>
                        <td>
                          <span class="badge bg-warning">{{ $karyawan->status }}</span>
                        </td>

                        <!-- <td> -->
                        <!--   <div class="form-check"> -->
                        <!--     <input type="checkbox" class="form-check-input"> -->
                        <!--   </div> -->
                        <!---->
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
              <!--         <li class="paginate_button page-item previous disabled" id="datatable_previous"><a href="@base_url(#)" -->
              <!--             aria-controls="datatable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li> -->
              <!--         <li class="paginate_button page-item active"><a href="@base_url(#)" aria-controls="datatable" data-dt-idx="1" -->
              <!--             tabindex="0" class="page-link">1</a></li> -->
              <!--         <li class="paginate_button page-item "><a href="@base_url(#)" aria-controls="datatable" data-dt-idx="2" -->
              <!--             tabindex="0" class="page-link">2</a></li> -->
              <!--         <li class="paginate_button page-item "><a href="@base_url(#)" aria-controls="datatable" data-dt-idx="3" -->
              <!--             tabindex="0" class="page-link">3</a></li> -->
              <!--         <li class="paginate_button page-item "><a href="@base_url(#)" aria-controls="datatable" data-dt-idx="4" -->
              <!--             tabindex="0" class="page-link">4</a></li> -->
              <!--         <li class="paginate_button page-item "><a href="@base_url(#)" aria-controls="datatable" data-dt-idx="5" -->
              <!--             tabindex="0" class="page-link">5</a></li> -->
              <!--         <li class="paginate_button page-item "><a href="@base_url(#)" aria-controls="datatable" data-dt-idx="6" -->
              <!--             tabindex="0" class="page-link">6</a></li> -->
              <!--         <li class="paginate_button page-item next" id="datatable_next"><a href="@base_url(#)" aria-controls="datatable" -->
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
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
