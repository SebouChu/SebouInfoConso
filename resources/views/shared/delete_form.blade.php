<form class="d-inline" action="{{ $action_url }}" method="post" onsubmit="return confirm('Are you sure?');">
  @method("DELETE")
  @csrf
  <input type="submit" class="btn btn-danger {{ isset($small) && $small ? 'btn-sm' : '' }}" value="{{ $label ?? 'Destroy' }}">
</form>