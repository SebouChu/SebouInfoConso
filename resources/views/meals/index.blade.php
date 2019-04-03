@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Meals</h1>

  <p>
    <a href="{{ route('meals.create') }}" class="btn btn-success">Add Meal</a>
  </p>

  @forelse ($mealsByDate as $date => $meals)
    <article class="my-4">
      <h3>{{ Carbon\Carbon::parse($date)->toFormattedDateString() }}</h2>
        <p>
          Total energy : {{ $meals->sum(function ($meal) {
            return $meal->totalEnergy();
          }) }} kcal
        </p>

        <table class="table table-striped table-hover">
          <thead>
            <th>Type</th>
            <th>Total energy</th>
            <th>Actions</th>
          </thead>
          <tbody>
            @foreach ($meals as $meal)
              <tr>
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
    </article>
  @empty
    <p>No meals yet...</p>
  @endforelse
</div>
@endsection