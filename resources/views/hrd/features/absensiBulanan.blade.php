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
              <div class="col-6">
                <h4 class="text-bold">{{ $karyawan->nama }}</h4>

              </div>
              <div class="col-6">
                <div class="btn-group float-right">
                  <a href="/hrd/absensiBulanan?id={{ $id }}&periode={{ $prevMonth }}" class="btn btn-primary">
                    <i class="nav-icon fas fa-chevron-left"></i>
                  </a>
                  <a href="/hrd/absensiBulanan?id={{ $id }}&periode={{ $nextMonth }}" class="btn btn-primary">
                    <i class="nav-icon fas fa-chevron-right"></i>
                  </a>
                </div>
              </div>
            </div>

            <!-- <div class="row"> -->
            <!--   <div class="col-12"> -->
            <!--     <form action="" method="get"> -->
            <!--       <div class="form-group"> -->
            <!--         <label for="tanggal-absensi">Tanggal Absensi</label> -->
            <!--         <input type="date" class="form-control" id="tanggal-absensi" name="tanggal_absensi" -->
            <!--           placeholder="Tanggal Absensi Karyawan"> -->
            <!--         <button type="submit" class="btn btn-primary">Submit</button> -->
            <!--       </div> -->
            <!--     </form> -->
            <!--   </div> -->
            <!-- </div> -->


            <!-- <div class="card-tools"> -->
            <!-- <button class="btn btn-primary">GEt</button> -->
            <!--   <a href="/hrd/absensi/bulanan?id=10" class="btn btn-primary">Bulanan</a> -->
            <!-- </div> -->

          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <!-- THE CALENDAR -->
            <div id="calendar" class="fc fc-media-screen fc-direction-ltr fc-theme-bootstrap fc-liquid-hack">
            </div>
            <!-- <div class="calendar"></div> -->
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

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        start: 'title', // will normally be on the left. if RTL, will be on the right
        center: '',
        end: '' // will normally be on the right. if RTL, will be on the left
      },
      initialView: 'dayGridMonth',
      initialDate: @json($initialDate),
      events: @json($dataAbsensi),  // URL ke controller PHP yang menyediakan data
      eventClick: function (info) {
        alert('Event: ' + info.event.title);
        alert('Description: ' + info.event.extendedProps.description);
      }
    });

    calendar.render();
  });
</script>

@endsection
