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
      <th>ID</th>
      <th>Date</th>
      <th>Type</th>
      <th>Actions</th>
    </thead>
    <tbody>
      @foreach ($meals as $meal)
        <tr>
          <td>{{ $meal->id }}</td>
          <td>{{ $meal->date }}</td>
          <td>{{ $meal->type }}</td>
          <td>
            <a class="btn btn-primary" href="{{ route('meals.show', $meal) }}">Show</a>
            <a class="btn btn-warning" href="{{ route('meals.edit', $meal) }}">Edit</a>
            @include('shared/delete_form', ['action_url' => route('meals.destroy', $meal)])
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