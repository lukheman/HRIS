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
    <div class="col-md-9"> 
        <div class="card">
          <div class="card-body">
          <p class="text-bold">Lokasi Absen</p>
            <div id="map" style="height: 400px;"></div>
          </div>
        </div>
    </div>
    <div class="col-md-3"> 
          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="text" class="form-control" id="latitude" value="{{ $pengaturan->latitude }}">
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="text" class="form-control" id="longitude" value="{{ $pengaturan->longitude }}">
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-body">
              <div class="form-group">
                <label for="radius-maksimal">Radius Maksimal</label>
                <input type="text" class="form-control" id="radius-maksimal" value="{{ $pengaturan->radius_maksimal }}">
              </div>
            </div>
          </div>

    </div>
    </div>
  </div>
</div>

<script>

  function ubahMarker(latitude, longitude) {
    if (marker) {
      map.removeLayer(marker);
    }

    marker = L.marker([latitude, longitude]).addTo(map)
    .bindPopup("Lokasi Absen")
    .openPopup();
  }

  function updatePengaturan (data) {
    $.ajax({
      url: '@base_url(/hrd/pengaturan/update)',
      method: 'POST',
      data: JSON.stringify(data),
      contentType: 'application/json',
      success: function (response) {
        console.log(response);
        if (data.latitude !== undefined || data.longitude !== undefined) {
          ubahMarker(response.data.latitude, response.data.longitude);
        }
      },
      error: function (error) {
        console.log(error);
      }
    });
  }

  $(document).ready(function () {

    $('#jam-masuk').on('input', function () {
      updatePengaturan({ jam_masuk: $(this).val() });
    });

    $('#jam-keluar').on('input', function () {
      updatePengaturan({ jam_keluar: $(this).val() });
    });

    $('#gaji-lembur').on('input', function () {
      updatePengaturan({ gaji_lembur: $(this).val() });
    });

    $('#latitude').on('change', function () {
      updatePengaturan({ latitude: $(this).val() });
    });

    $('#longitude').on('change', function () {
      updatePengaturan({ longitude: $(this).val() });
    });

    $('#radius-maksimal').on('change', function () {
      updatePengaturan({ radius_maksimal: $(this).val() });
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
        $('#latitude').val(data.data.latitude);
        $('#longitude').val(data.data.longitude);

        ubahMarker(data.data.latitude, data.data.longitude);
      },
      error: function (error) {
        console.log(error);
      }
    });

  });

</script>

@endsection
