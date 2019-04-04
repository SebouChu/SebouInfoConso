@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Add Product to Meal #{{ $meal->id }}</h1>

  <form class="meals__product-form" method="post" action="{{ route('meals.products.store', $meal) }}">
    @csrf

    <div class="form-group mt-3">
      @if($products->count() > 0)
        <div class="form-check form-inline mb-2">
          <input class="form-check-input" type="radio" name="barcode_source" value="select" {{ old('barcode') === null ? 'checked' : '' }}>
          <select class="form-control ml-2" name="barcode" required {{ old('barcode') === null ? '' : 'disabled' }}>
              <option value="" selected disabled>Select a product</option>
              @foreach ($products as $product)
                <option value="{{ $product->barcode }}">{{ $product->name }}</option>
              @endforeach
          </select>
        </div>

        <div class="form-check form-inline mb-2">
          <input class="form-check-input" type="radio" name="barcode_source" value="input" {{ old('barcode') !== null ? 'checked' : '' }}>
          <label class="form-check-label ml-2">
            Or enter the barcode :
            <input class="form-control ml-2" type="text" name="barcode" id="barcode_input" placeholder="3029330003533" value="{{ old('barcode') }}" required {{ old('barcode') !== null ? '' : 'disabled' }}>
          </label>
        </div>
      @else
        <label class="form-control-label" for="title">
          Barcode
          <abbr title="required">*</abbr>
        </label>

        <input class="form-control" type="text" name="barcode" id="barcode_input" placeholder="3029330003533" value="{{ old('barcode') }}" required {{ old('barcode') !== null ? '' : 'disabled' }}>
      @endif

    </div>

    <input type="submit" value="Save" class="btn btn-success d-inline">
    @include('shared/back_button')
  </form>
</div>
@endsection