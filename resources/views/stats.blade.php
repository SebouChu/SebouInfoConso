@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="mb-4">Stats</h1>

  @if($mostEnergizingConsumedProducts->count() > 0)
    <article class="my-3">
      <h2>Most energizing consumed products</h2>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Barcode</th>
            <th>Name</th>
            <th>Energy</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($mostEnergizingConsumedProducts as $product)
            <tr>
              <td>
                <a href="{{ route('products.show', $product->barcode) }}">
                  {{ $product->barcode }}
                </a>
              </td>
              <td>{{ $product->name }}</td>
              <td>{{ $product->energy }} kcal</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </article>
  @endif

  @if($leastEnergizingConsumedProducts->count() > 0)
    <article class="my-3">
      <h2>Least energizing consumed products</h2>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Barcode</th>
            <th>Name</th>
            <th>Energy</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($leastEnergizingConsumedProducts as $product)
            <tr>
                <td>
                  <a href="{{ route('products.show', $product->barcode) }}">
                    {{ $product->barcode }}
                  </a>
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->energy }} kcal</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </article>
  @endif

  @if($mostEnergizingProductsByTotalConsumed->count() > 0)
    <article class="my-3">
      <h2>Most energizing products by total consumed</h2>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Barcode</th>
            <th>Name</th>
            <th>Total Energy (Consumed count)</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($mostEnergizingProductsByTotalConsumed as $product)
          <tr>
            <td>
              <a href="{{ route('products.show', $product->barcode) }}">
                {{ $product->barcode }}
              </a>
            </td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->totalEnergy }} kcal ({{ $product->consumedCount }})</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </article>
  @endif
</div>
@endsection
