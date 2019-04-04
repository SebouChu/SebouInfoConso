@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Meal #{{ $meal->id }}</h1>

  <p>Infos :</p>
  <ul>
    <li>Date : {{ $meal->formattedDate() }}</li>
    <li>Type : {{ \App\Enums\MealType::getDescription($meal->type) }}</li>
    <li>Total energy : {{ $meal->totalEnergy() }} kcal</li>
  </ul>

  <h2>Products</h2>
  <p>
    <a class="btn btn-success btn-sm" href="{{ route('meals.products.create', $meal) }}">Add Product</a>
  </p>

  @if ($meal->products->count() == 0)
    No products yet.
  @else
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Barcode</th>
          <th>Name</th>
          <th>Energy</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($meal->products as $product)
          <tr>
            <td>
              <a href="{{ route('products.show', $product) }}">{{ $product->barcode }}</a>
            </td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->energy }} kcal</td>
            <td>
              @include('shared/delete_form', [
                'action_url' => route('meals.products.destroy',[$meal, $product]),
                'small' => true,
                'label' => 'Remove'
              ])
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif

  <hr>

  <div class="links">
    <a class="btn btn-warning" href="{{ route('meals.edit', $meal) }}">Edit</a>
    @include('shared/delete_form', ['action_url' => route('meals.destroy', $meal)])
    <a class="btn btn-outline-primary" href="{{ route('meals.index') }}">Back to Meals</a>
  </div>
</div>
@endsection