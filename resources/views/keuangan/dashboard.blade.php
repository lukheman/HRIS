@extends('layouts.main') <!-- gunakan layout main -->

@section('title', strtoupper($role))

@section('sidebar-menu')

@include($role . '.menu')

@endsection

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">

      <div class="col-lg-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3> {{ $totalKaryawan }} Orang</h3>
            <p>Karyawan</p>
          </div>
          <div class="icon">
            <i class="ion ion-person"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <!-- total gaji pada bulan sebelumnya -->
            <h3>Rp. {{ number_format($totalGaji, 2, ',', '.') }}</h3>
            <p>{{ $periode }}</p>
          </div>
          <div class="icon">
            <i class="ion ion-cash"></i>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>

@endsection
