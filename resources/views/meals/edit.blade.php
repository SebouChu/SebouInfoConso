@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Edit Meal #{{ $meal->id }}</h1>

  @include('meals/_form', compact('meal'))
</div>
@endsection