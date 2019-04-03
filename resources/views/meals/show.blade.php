@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Meal #{{ $meal->id }}</h1>

  <p>Infos :</p>
  <ul>
    <li>Date : {{ $meal->date }}</li>
    <li>Type : {{ \App\Enums\MealType::getDescription($meal->type) }}</li>
  </ul>

  <h2>Products</h2>
  <p>
    <a class="btn btn-success btn-sm" href="{{ route('meals.products.create', $meal) }}">Add Product</a>
  </p>

  @if ($meal->products->count() == 0)
    No products yet.
  @else
    <table class="table table-hover table-striped table-responsive-lg">
      <thead>
        <tr>
          <th>Product</th>
          <th>Barcode</th>
          <th>Energy</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($meal->products() as $product)
          <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->barcode }}</td>
            <td>{{ $product->energy }}</td>
            <td>TODO : Delete from JoinTable</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif

  <hr>

  <div class="links">
    <a class="btn btn-warning" href="{{ route('meals.edit', $meal) }}">Edit</a>
    @include('shared/delete_form', ['action_url' => route('meals.destroy', $meal)])
    <a class="btn btn-outline-primary" href="{{ route('meals.index') }}">Back</a>
  </div>
</div>
@endsection