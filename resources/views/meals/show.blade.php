@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Meal #{{ $meal->id }}</h1>

  <p>Infos :</p>
  <ul>
    <li>Date : {{ $meal->date }}</li>
    <li>Type : {{ \App\Enums\MealType::getDescription($meal->type) }}</li>
  </ul>

  <hr>

  <div class="links">
    <a class="btn btn-warning" href="{{ route('meals.edit', $meal) }}">Edit</a>
    @include('shared/delete_form', ['action_url' => route('meals.destroy', $meal)])
    <a class="btn btn-outline-primary" href="{{ route('meals.index') }}">Back</a>
  </div>
</div>
@endsection