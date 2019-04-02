@extends('layouts.app')

@section('content')
<div class="container">
  <h1>New Meal</h1>

  @include('meals/_form', compact('meal'))
</div>
@endsection