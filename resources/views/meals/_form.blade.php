<form method="post" action="{{ $meal->exists ? route('meals.update', $meal->id) : route('meals.store') }}">
  @csrf

  @if ($meal->exists)
    @method('PUT')
  @endif

  <div class="form-row">

    <div class="col-md-6">
      <div class="form-group">
        <label class="form-control-label" for="title">
          Date
          <abbr title="required">*</abbr>
        </label>
        <input class="form-control" type="date" name="date" value="{{ $meal->date }}" required>
      </div>
    </div>

    <div class="col-md-6">
      <div class="form-group">
        <label class="form-control-label" for="description">Type</label>
        <select class="form-control" name="type">
          @foreach (\App\Enums\MealType::toSelectArray() as $value => $description)
            <option value="{{ $value }}" {{ $value === $meal->type ? 'selected' : '' }}>{{ $description }}</option>
          @endforeach
        </select>
      </div>
    </div>

  </div>

  <input type="submit" value="Save" class="btn btn-success d-inline">
  <a class="btn btn-outline-primary" href="{{ $meal->exists ? route('meals.show', $meal) : route('meals.index') }}">Back</a>
</form>