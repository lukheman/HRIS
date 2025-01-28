@extends('layouts.main') <!-- gunakan layout main -->

@section('title', strtoupper($role))

@section('sidebar-menu')

@include( $role .'.menu')

@endsection

@section('content')

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle" src="@base_url(/assets/img/avatar5.png)"
                alt="User profile picture">
            </div>

            <h3 class="profile-username text-center">{{ $karyawan->nama }}</h3>

            <p class="text-muted text-center">{{ $karyawan->jabatan }}</p>

            <!--<ul class="list-group list-group-unbordered mb-3">-->
            <!--  <li class="list-group-item">-->
            <!--    <b>Followers</b> <a class="float-right">1,322</a>-->
            <!--  </li>-->
            <!--  <li class="list-group-item">-->
            <!--    <b>Following</b> <a class="float-right">543</a>-->
            <!--  </li>-->
            <!--  <li class="list-group-item">-->
            <!--    <b>Friends</b> <a class="float-right">13,287</a>-->
            <!--  </li>-->
            <!--</ul>-->

            <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- About Me Box -->
        <!--<div class="card card-primary">-->
        <!--  <div class="card-header">-->
        <!--    <h3 class="card-title">About Me</h3>-->
        <!--  </div>-->
        <!--  <div class="card-body">-->
        <!--    <strong><i class="fas fa-book mr-1"></i> Education</strong>-->
        <!---->
        <!--    <p class="text-muted">-->
        <!--      B.S. in Computer Science from the University of Tennessee at Knoxville-->
        <!--    </p>-->
        <!---->
        <!--    <hr>-->
        <!---->
        <!--    <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>-->
        <!---->
        <!--    <p class="text-muted">Malibu, California</p>-->
        <!---->
        <!--    <hr>-->
        <!---->
        <!--    <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>-->
        <!---->
        <!--    <p class="text-muted">-->
        <!--      <span class="tag tag-danger">UI Design</span>-->
        <!--      <span class="tag tag-success">Coding</span>-->
        <!--      <span class="tag tag-info">Javascript</span>-->
        <!--      <span class="tag tag-warning">PHP</span>-->
        <!--      <span class="tag tag-primary">Node.js</span>-->
        <!--    </p>-->
        <!---->
        <!--    <hr>-->
        <!---->
        <!--    <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>-->
        <!---->
        <!--    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.-->
        <!--    </p>-->
        <!--  </div>-->
        <!--</div>-->
        <!-- /.card -->

      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <!-- <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li> -->
              <!-- <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li> -->

              <li class="nav-item"><a class="nav-link active" href="#password" data-toggle="tab">Password</a></li>
              <li class="nav-item"><a class="nav-link" href="#qrcode" data-toggle="tab">QR Code</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">


              <div class="tab-pane active " id="password">
                @if (isset($message))
                <div class="card card-warning">
                  <div class="card-header">
                    <h3 class="card-title"></h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                      </button>
                    </div>
                    <!-- /.card-tools -->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    {{ $message }}
                  </div>
                  <!-- /.card-body -->
                </div>

                @endif

                <form class="form-horizontal" action="@base_url(/{{ $role }}/profile/update-password)" method="post">
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                      <input type="password" name="newPassword" class="form-control" id="inputPassword"
                        placeholder="Password baru" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Konfirmasi</label>
                    <div class="col-sm-10">
                      <input type="password" name="confirmNewPassword" class="form-control" id="inputKonfirmasiPassword"
                        placeholder="Konfirmasi Pasword Baru" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Ubah</button>
                    </div>
                  </div>
                </form>
              </div>

              <div class="tab-pane" id="qrcode">

                <div class="row">
                  <div class="col-12">
                    <img class="img-fluid" src="" id="img-qrcode">
                  </div>
                </div>

              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>

<script>

  document.addEventListener('DOMContentLoaded', async () => {
    let qrcode = document.getElementById('img-qrcode');

    try {
      const response = await fetch('@base_url(/karyawan/generate-qrcode/generate)', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          nik: @json($karyawan -> nik)
        })
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'Terjadi kesalahan');
      }

      const blob = await response.blob();
      const qrCodeUrl = URL.createObjectURL(blob);

      qrcode.src = qrCodeUrl;

      // nikKaryawan.value = btn.value;
      // btnCetakQrCode.style.display = 'block';

    } catch (error) {
      console.error('Error:', error);
      alert('Gagal generate QR Code: ' + error.message);
    }


  });


  // TODO: gunakan jquery untuk melakuakn dom
</script>

@endsection
