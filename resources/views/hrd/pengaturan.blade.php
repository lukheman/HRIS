@extends('layouts.main') <!-- gunakan layout main -->

@section('title', strtoupper($role))

@section('sidebar-menu')

@include($role . '.menu')

@endsection

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <!-- <div class="card-header"> -->
          <!--   <h6 class="card-title">Jam Masuk</h6> -->
          <!-- </div> -->
          <div class="card-body">
            <div class="form-group">
              <div class="form-group">
                <label for="jam-masuk">Jam Masuk</label>
                <input type="time" class="form-control" id="jam-masuk" value="{{ $pengaturan->jam_masuk }}">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <!-- <div class="card-header"> -->
          <!--   <h6 class="card-title">Jam Keluar</h6> -->
          <!-- </div> -->
          <div class="card-body">
            <div class="form-group">
              <label for="jam-keluar">Jam Keluar</label>
              <input type="time" class="form-control" id="jam-keluar" value="{{ $pengaturan->jam_keluar }}">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
          <p class="text-bold">Lokasi Absen</p>
            <div id="map" style="height: 400px;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

  $(document).ready(function () {

    $('#jam-masuk').on('input', function () {

      $.ajax({
        url: '@base_url(/hrd/pengaturan/update)',
        method: 'POST',
        data: JSON.stringify({jam_masuk: $(this).val()}),
        contentType: 'application/json',
        success: function (data) {
          location.reload();
        },
        error: function (error) {
          console.log(error);
        }
      });

    });

    $('#jam-keluar').on('input', function () {

      $.ajax({
        url: '@base_url(/hrd/pengaturan/update)',
        method: 'POST',
        data: JSON.stringify({jam_keluar: $(this).val()}),
        contentType: 'application/json',
        success: function (data) {
          location.reload();
        },
        error: function (error) {
          console.log(error)
        }
      })
    });

    $('#gaji-lembur').on('input', function () {

      $.ajax({
        url: '@base_url(/hrd/pengaturan/update)',
        method: 'POST',
        data: JSON.stringify({gaji_lembur: $(this).val()}),
        contentType: 'application/json',
        success: function (data) {
          location.reload();
        },
        error: function (error) {
          console.log(error)
        }
      })
    });

  });

</script>

<script>

  var map = L.map('map').setView([{{ $pengaturan->latitude }}, {{ $pengaturan->longitude }}], 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  var marker = L.marker([{{ $pengaturan->latitude }}, {{ $pengaturan->longitude }}]).addTo(map)
    .bindPopup("Lokasi Absen")
    .openPopup();

  map.on('click', function (e) {
    var latitude = e.latlng.lat; // Latitude
    var longitude = e.latlng.lng; // Longitude

      $.ajax({
        url: '@base_url(/hrd/pengaturan/update)',
        method: 'POST',
        data: JSON.stringify({ 
          latitude, longitude
        }),
        contentType: 'application/json',
        success: function (data) {
          location.reload();
        },
        error: function (error) {
          console.log(error);
        }
      });

    // Hapus marker sebelumnya jika ada
    if (marker) {
      map.removeLayer(marker);
    }

    // Tambahkan marker ke lokasi yang diklik
    marker = L.marker([latitude, longitude]).addTo(map)
    .bindPopup("Lokasi Absen")
    .openPopup();
  });

</script>

@endsection
