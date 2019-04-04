@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="mb-4">Welcome {{ Auth::user()->name }}!</h1>

  <article class="my-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h2 class="mb-0">Your recent meals</h2>
      <a href="{{ route('meals.index') }}" class="btn btn-outline-primary">All Meals</a>
    </div>
    @if($recentMeals->count() > 0)
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Total energy</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($recentMeals as $meal)
            <tr>
              <td>{{ $meal->formattedDate() }}</td>
              <td>{{ \App\Enums\MealType::getDescription($meal->type) }}</td>
              <td>{{ $meal->totalEnergy() }} kcal</td>
              <td>
                <a class="btn btn-primary btn-sm" href="{{ route('meals.show', $meal) }}">Show</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <p>You don't have any meals yet! You can create one right <a href="{{ route('meals.create') }}">here</a>.</p>
    @endif
  </article>

  @if($lastImportedProducts->count() > 0)
    <article class="my-3">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h2 class="mb-0">Last imported products</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">All Products</a>
      </div>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Barcode</th>
            <th>Name</th>
            <th>Energy</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($lastImportedProducts as $product)
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
</div>
@endsection
