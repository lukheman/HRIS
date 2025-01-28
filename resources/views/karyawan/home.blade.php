@extends('layouts.main') <!-- gunakan layout main -->

@section('title', strtoupper($role))

@section('sidebar-menu')

@include( $role .'.menu')

@endsection

@section('content')

<h1>ini dashboard karyawan perorang</h1>

@endsection
