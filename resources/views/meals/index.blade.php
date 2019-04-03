@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Meals</h1>

  <p>
    <a href="{{ route('meals.create') }}" class="btn btn-success">Add Meal</a>
  </p>

  @if ($meals->count() > 0)
  <table class="table table-striped table-hover">
    <thead>
      <th>Date</th>
      <th>Type</th>
      <th>Total energy</th>
      <th>Actions</th>
    </thead>
    <tbody>
      @foreach ($meals as $meal)
        <tr>
          <td>{{ $meal->formattedDate() }}</td>
          <td>{{ \App\Enums\MealType::getDescription($meal->type) }}</td>
          <td>{{ $meal->totalEnergy() }} kcal</td>
          <td>
            <a class="btn btn-primary btn-sm" href="{{ route('meals.show', $meal) }}">Show</a>
            <a class="btn btn-warning btn-sm" href="{{ route('meals.edit', $meal) }}">Edit</a>
            @include('shared/delete_form', ['action_url' => route('meals.destroy', $meal), 'small' => true])
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  @else
    <p>No meals yet...</p>
  @endif
</div>
@endsection