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
                <button class="btn btn-primary float-end" id="btn-tambah-jabatan" data-toggle="modal"
                  data-target="#modal-tambah-jabatan">
                  <i class="nav-icon fas fa-plus"></i>
                  Tambah Jabatan</button>

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
                          Jabatan</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1">
                          Gaji (Rp.)</th>
                        <th class="sorting" tabindex="0" aria-controls="datatable" rowspan="1" colspan="1"
                          width="200px">
                          Aksi</th>
                      </tr>
                    </thead>
                    <tbody>

                      @foreach ($jabatan as $item)
                      <tr>
                        <td>{{ $item->jabatan}}</td>
                        <td>{{ number_format($item->gaji, 0, ',', '.') }}</td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-sm btn-outline-primary btn-edit-jabatan" data-toggle="modal"
                              data-id-jabatan="{{ $item->id }}" data-target="#modal-edit-jabatan">
                              <i class="nav-icon fas fa-pencil-alt"></i>
                              Edit</button>
                            <button class="btn btn-sm btn-outline-danger btn-hapus-jabatan"
                              data-id-jabatan="{{ $item->id }}">
                              <i class="nav-icon fas fa-trash"></i>
                              Hapus</button>
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

<!-- modal edit jabatan -->
<div class="modal fade show" id="modal-edit-jabatan" style="display: none;" aria-modal="true" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Jabatan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="@base_url(/hrd/jabatan/update)" id="form-edit-jabatan" method="post">
        <div class="modal-body">

          <input type="hidden" name="id_jabatan" id="id-jabatan">

          <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan" required>
          </div>

          <div class="form-group">
            <label for="gaji">Gaji</label>
            <input type="number" class="form-control" id="gaji" name="gaji" required>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan perubahan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- modal tambah jabatan -->
<div class="modal fade show" id="modal-tambah-jabatan" style="display: none;" aria-modal="true" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Jabatan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="form-tambah-jabatan" action="@base_url(/hrd/jabatan/add)" method="post">
        <div class="modal-body">

          <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukan jabatan" required>
          </div>

          <div class="form-group">
            <label for="gaji">Gaji</label>
            <input type="number" class="form-control" id="gaji" name="gaji" placeholder="Masukan gaji" required>
          </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  $(document).ready(() => {

    $('.btn-edit-jabatan').click(function () {

      let idJabatan = $(this).data('id-jabatan');

      $.ajax({
        url: '@base_url(/hrd/jabatan/show)',
        method: 'GET',
        data: {id: idJabatan},
        success: function (data) {
          let jabatan = data.data;
          $('#form-edit-jabatan').find('#id-jabatan').val(jabatan.id);
          $('#form-edit-jabatan').find('#jabatan').val(jabatan.jabatan);
          $('#form-edit-jabatan').find('#gaji').val(jabatan.gaji);
        },
        error: function (error) {
          console.log(error);
        },
      })
    });

    $('.btn-hapus-jabatan').click(function () {
      let idJabatan = $(this).data('id-jabatan');

      $.ajax({
        url: '@base_url(/hrd/jabatan/delete)',
        method: 'POST',
        data: {id: idJabatan},
        // headers: {
        //   'Content-Type': 'application/json',
        // },
        success: function (data) {
          console.log(data);
          if (data.success) {
            Swal.fire(data.message, '', '').then(() => location.reload());
          }
        },
        error: function (error) {
          console.log(error);
        },
      });
    });

  });
</script>
@endsection
