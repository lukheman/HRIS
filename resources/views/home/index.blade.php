@extends('layouts.main')

@section('title', $title)

@section('content')
<div class="container">
  <h1>{{ $title }}</h1>
  <p>{{ $content }}</p>
</div>
@endsection
