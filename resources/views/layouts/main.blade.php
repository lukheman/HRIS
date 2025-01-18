<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FBS | @yield('title', 'Default Title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/css/adminlte.min.css">
  <!-- fullCalendar -->
  <link rel="stylesheet" href="/plugins/fullcalendar/main.css">

  <!-- instascan/camera -->
  <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

  <!-- jQuery -->
  <script src="/plugins/jquery/jquery.min.js"></script>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    @include('layouts.navbar')

    @include('layouts.sidebar')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"> {{ $subpage }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">{{ $page }}</a></li>
                <li class="breadcrumb-item active">{{ $subpage }}</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <!-- <aside class="control-sidebar control-sidebar-dark"> -->
    <!-- Control sidebar content goes here -->
    <!--   <div class="p-3"> -->
    <!--     <h5>Title</h5> -->
    <!--     <p>Sidebar content</p> -->
    <!--   </div> -->
    <!-- </aside> -->
    <!-- /.control-sidebar -->

    @include('layouts.footer')

  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->


  <!-- Bootstrap 4 -->
  <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- jQuery UI -->
  <script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/assets/js/adminlte.min.js"></script>
  <!-- fullCalendar 2.2.5 -->
  <script src="/plugins/moment/moment.min.js"></script>
  <script src="/plugins/fullcalendar/main.js"></script>

  <!-- DataTables  & Plugins -->
  <script src="/plugins/datatables/jquery.dataTables.min.js"></script>

  <script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <!-- <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script> -->
  <!-- <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> -->
  <!-- <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script> -->
  <!-- <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script> -->
  <!-- <script src="plugins/jszip/jszip.min.js"></script> -->
  <!-- <script src="plugins/pdfmake/pdfmake.min.js"></script> -->
  <!-- <script src="plugins/pdfmake/vfs_fonts.js"></script> -->
  <!-- <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script> -->
  <!-- <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script> -->
  <!-- <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script> -->


  <script>
    $(document).ready(function () {

      $('#datatable').DataTable({
        "searching": true,  // Aktifkan fitur pencarian
        "paging": false,    // Nonaktifkan fitur paginasi (opsional)
        "ordering": false   // Nonaktifkan pengurutan (opsional)
      });
    });
  </script>


</body>

</html>
