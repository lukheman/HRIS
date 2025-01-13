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
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    @include('layouts.navbar')

    @include('layouts.sidebar')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
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

  <!-- jQuery -->
  <script src="/plugins/jquery/jquery.min.js"></script>
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
    $(function () {

      /* initialize the external events
       -----------------------------------------------------------------*/
      function ini_events(ele) {
        ele.each(function () {

          // create an Event Object (https://fullcalendar.io/docs/event-object)
          // it doesn't need to have a start or end
          var eventObject = {
            title: $.trim($(this).text()) // use the element's text as the event title
          }

          // store the Event Object in the DOM element so we can get to it later
          $(this).data('eventObject', eventObject)

          // make the event draggable using jQuery UI
          $(this).draggable({
            zIndex: 1070,
            revert: true, // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
          })

        })
      }

      ini_events($('#external-events div.external-event'))

      /* initialize the calendar
       -----------------------------------------------------------------*/
      //Date for the calendar events (dummy data)
      var date = new Date()
      var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear()

      var Calendar = FullCalendar.Calendar;
      var Draggable = FullCalendar.Draggable;

      var containerEl = document.getElementById('external-events');
      var checkbox = document.getElementById('drop-remove');
      var calendarEl = document.getElementById('calendar');

      // initialize the external events
      // -----------------------------------------------------------------

      new Draggable(containerEl, {
        itemSelector: '.external-event',
        eventData: function (eventEl) {
          return {
            title: eventEl.innerText,
            backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
            borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
            textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
          };
        }
      });

      var calendar = new Calendar(calendarEl, {
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        themeSystem: 'bootstrap',
        //Random default events
        events: [
          {
            title: 'All Day Event',
            start: new Date(y, m, 1),
            backgroundColor: '#f56954', //red
            borderColor: '#f56954', //red
            allDay: true
          },
          {
            title: 'Long Event',
            start: new Date(y, m, d - 5),
            end: new Date(y, m, d - 2),
            backgroundColor: '#f39c12', //yellow
            borderColor: '#f39c12' //yellow
          },
          {
            title: 'Meeting',
            start: new Date(y, m, d, 10, 30),
            allDay: false,
            backgroundColor: '#0073b7', //Blue
            borderColor: '#0073b7' //Blue
          },
          {
            title: 'Lunch',
            start: new Date(y, m, d, 12, 0),
            end: new Date(y, m, d, 14, 0),
            allDay: false,
            backgroundColor: '#00c0ef', //Info (aqua)
            borderColor: '#00c0ef' //Info (aqua)
          },
          {
            title: 'Birthday Party',
            start: new Date(y, m, d + 1, 19, 0),
            end: new Date(y, m, d + 1, 22, 30),
            allDay: false,
            backgroundColor: '#00a65a', //Success (green)
            borderColor: '#00a65a' //Success (green)
          },
          {
            title: 'Click for Google',
            start: new Date(y, m, 28),
            end: new Date(y, m, 29),
            url: 'https://www.google.com/',
            backgroundColor: '#3c8dbc', //Primary (light-blue)
            borderColor: '#3c8dbc' //Primary (light-blue)
          }
        ],
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar !!!
        drop: function (info) {
          // is the "remove after drop" checkbox checked?
          if (checkbox.checked) {
            // if so, remove the element from the "Draggable Events" list
            info.draggedEl.parentNode.removeChild(info.draggedEl);
          }
        }
      });

      calendar.render();
      // $('#calendar').fullCalendar()

      /* ADDING EVENTS */
      var currColor = '#3c8dbc' //Red by default
      // Color chooser button
      $('#color-chooser > li > a').click(function (e) {
        e.preventDefault()
        // Save color
        currColor = $(this).css('color')
        // Add color effect to button
        $('#add-new-event').css({
          'background-color': currColor,
          'border-color': currColor
        })
      })
      $('#add-new-event').click(function (e) {
        e.preventDefault()
        // Get value and make sure it is not null
        var val = $('#new-event').val()
        if (val.length == 0) {
          return
        }

        // Create events
        var event = $('<div />')
        event.css({
          'background-color': currColor,
          'border-color': currColor,
          'color': '#fff'
        }).addClass('external-event')
        event.text(val)
        $('#external-events').prepend(event)

        // Add draggable funtionality
        ini_events(event)

        // Remove event from text input
        $('#new-event').val('')
      })
    })
  </script>

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
