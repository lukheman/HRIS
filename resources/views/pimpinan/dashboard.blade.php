@extends('layouts.main') <!-- gunakan layout main -->

@section('title', 'Home')

@section('sidebar-menu')

@include('pimpinan.menu')

@endsection

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">

      <div class=" col-6">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Jumlah Karyawan</span>
            <span class="info-box-number">{{ $karyawanCount }}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
      </div>

      <div class=" col-6">
        <div class="info-box">
          <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Messages</span>
            <span class="info-box-number">1,410</span>
          </div>
          <!-- /.info-box-content -->
        </div>
      </div>

    </div>
  </div>
</div>

@endsection
