@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Edit Product in Meal #{{ $meal->id }}</h1>

  <form class="meals__product-form" method="post" action="{{ route('meals.products.update', [$meal, $product]) }}">
    @csrf

    @method('PUT')

    @include('shared/form_errors', compact('errors'))

    <p><strong>Product</strong> : {{ $product->name }} ({{ $product->barcode }})</p>

    <div class="form-group">
      <label for="quantity" class="form-control-label">
        Quantity
        <abbr title="required">*</abbr>
      </label>
      <input type="number" name="quantity" class="form-control quantity-input" min="1" value="{{ $quantity }}" required>
    </div>

    <input type="submit" value="Save" class="btn btn-success d-inline">
    @include('shared/back_button')
  </form>
</div>
@endsection