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
            <h3>{{ $totalStatus['hadir'] }}</h3>
            <p>Hadir</p>
          </div>
          <div class="icon">
            <i class="ion ion-person"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{ $totalStatus['alpha'] }}</h3>
            <p>Alpha</p>
          </div>
          <div class="icon">
            <i class="ion ion-person"></i>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>

@endsection
