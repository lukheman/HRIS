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
                <a class="btn btn-primary float-end" href="/hrd/karyawan/add">Tambah Karyawan</a>
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
                        <!--     <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" -->
                        <!--       aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending"> -->
                        <!-- </th> -->
                        <!--     <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" -->
                        <!--       aria-label="Browser: activate to sort column ascending">Browser</th> -->
                        <!--     <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" -->
                        <!--       aria-label="Platform(s): activate to sort column ascending">Platform(s)</th> -->
                        <!--     <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" -->
                        <!--       aria-label="Engine version: activate to sort column ascending">Engine version</th> -->
                        <!-- <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1" -->
                        <!--       aria-label="CSS grade: activate to sort column ascending" style="display: none;">CSS grade -->
                        <!--     </th> -->
                        <!--    <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">-->
                        <!--ID Karyawan</th>-->
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
                        <td>{{ $karyawan->gaji}}</td>
                        <td>
                          <div class="btn-group">
                            <form action="/hrd/karyawan/update" method="get">
                              <input type="hidden" name="id" value="{{ $karyawan->id }}">
                              <button type="submit" class="btn  btn-sm btn-primary">Update</button>
                            </form>
                            <form action="/hrd/karyawan/delete" method="post">
                              <input type="hidden" name="id" value="{{ $karyawan->id }}">
                              <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>


                          </div>
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
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection
