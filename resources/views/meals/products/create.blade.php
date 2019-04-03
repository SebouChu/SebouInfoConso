@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Add Product to Meal #{{ $meal->id }}</h1>

  <form method="post" action="{{ route('meals.products.store', $meal) }}">
    @csrf

    <div class="form-group">
      <label class="form-control-label" for="title">
        Barcode
        <abbr title="required">*</abbr>
      </label>
      <input class="form-control" type="text" name="barcode" placeholder="3029330003533" value="{{ old('barcode') }}" required>
    </div>

    <input type="submit" value="Save" class="btn btn-success d-inline">
    <a class="btn btn-outline-primary" href="{{ route('meals.show', $meal) }}">Back</a>
  </form>
</div>
@endsection