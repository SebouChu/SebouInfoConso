@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row align-items-center mb-4">
    <div class="col-md-4">
      <img class="img-fluid" src="{{ $product->image }}" alt="{{ $product->name }}">
    </div>
    <div class="col-md-8">
      <h1>{{ $product->name }}</h1>

      <ul>
        <li>Barcode : {{ $product->barcode }}</li>
        <li>Energy : {{ $product->energy }} kcal</li>
      </ul>
    </div>
  </div>


  <hr>

  <div class="links">
    @include('shared/back_button')
  </div>
</div>
@endsection