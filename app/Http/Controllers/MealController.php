<?php

namespace App\Http\Controllers;

use App\Meal;
use App\Enums\MealType;
use BenSampo\Enum\Rules\EnumValue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MealController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index() {
    return view('meals/index', [
      'meals' => Auth::user()->meals()->with('products')->get()
    ]);
  }

  public function show(Meal $meal) {
    $this->authorize('view', $meal);

    return view('meals/show', compact('meal'));
  }

  public function create() {
    $meal = new Meal();
    $meal->date = Carbon::now()->toDateString();

    return view('meals/create', compact('meal'));
  }

  public function store(Request $request) {
    $attributes = $request->validate([
      'date' => 'required|date',
      'type' => ['required', new EnumValue(MealType::class, false)]
    ]);

    $meal = new Meal();
    $meal->date = $attributes['date'];
    $meal->type = $attributes['type'];
    $meal->user()->associate(Auth::user());

    $meal->save();

    Session::flash('notice', 'Meal was successfully created!');

    return redirect()->route('meals.show', $meal->id);
  }

  public function edit(Meal $meal) {
    $this->authorize('update', $meal);

    return view('meals/edit', compact('meal'));
  }

  public function update(Request $request, Meal $meal) {
    $this->authorize('update', $meal);

    $attributes = $request->validate([
      'date' => 'required|date',
      'type' => ['required', new EnumValue(MealType::class, false)]
    ]);

    $meal->date = $attributes['date'];
    $meal->type = $attributes['type'];

    $meal->save();
    Session::flash('notice', 'Meal was successfully updated!');

    return redirect()->route('meals.show', $meal->id);
  }

  public function destroy(Meal $meal) {
    $this->authorize('delete', $meal);

    $meal->delete();
    Session::flash('notice', 'Meal was successfully destroyed!');

    return redirect()->route('meals.index');
  }
}
