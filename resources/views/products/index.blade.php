@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Products</h1>

  @if ($products->count() > 0)
  <table class="table table-striped table-hover">
    <thead>
      <th>Barcode</th>
      <th>Name</th>
    </thead>
    <tbody>
      @foreach ($products as $product)
        <tr>
          <td>
            <a href="{{ route('products.show', $product) }}">{{ $product->barcode }}</a>
          </td>
          <td>{{ $product->name }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
  @else
    <p>No products yet...</p>
  @endif
</div>
@endsection