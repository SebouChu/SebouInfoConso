<?php

namespace App\Http\Controllers;

use App\Meal;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function create(Meal $meal) {
    $this->authorize('update', $meal);

    return view('meals/create', [
      'meal' => $meal,
      'product' => new Product()
    ]);
  }

  public function store(Request $request, Meal $meal) {
    $this->authorize('update', $meal);

    $attributes = $request->validate([
      'barcode' => 'required'
    ]);

    $product = search($attributes['barcode']);
    if ($product === null) {
      return redirect()->back()->with('alert', ['Product not found.']);
    }

    $meal->products()->attach($product)->save();

    Session::flash('notice', 'Product was successfully added to your meal!');

    return redirect()->route('meals.show', $meal->id);
  }

  public function destroy(Meal $meal, Product $product) {
    $this->authorize('update', $meal);

    $meal->products()->detach($product);
    Session::flash('notice', 'Product was successfully deleted from your meal!');

    return redirect()->route('meals.show', $meal->id);
  }

  // PRIVATE //

  private function search(string $barcode) {
    $product = Product::where('barcode', $barcode)->first();

    if ($product !== null) {
      return $product;
    }

    $url = 'https://fr.openfoodfacts.org/api/v0/produit/'.$barcode.'.json';
    $data = json_decode(file_get_contents($url), true);

    if ($data['status'] === 0) {
      return null;
    }

    $product = $this->import($barcode, $data);

    return $product;
  }

  private function import(string $barcode, array $data) {
    $name = data['product']['product_name'];
    $image = data['product']['image_url'];

    $energyUnit = data['product']['nutriments']['energy_unit'];
    $energy = intval(data['product']['nutriments']['energy']);
    if ($energyUnit === 'kJ') {
      $energy = round($energy / 4.184);
    }

    $product = new Product();
    $product->name = $name;
    $product->image = $image;
    $product->barcode = $barcode;
    $product->energy = $energy;
    $product->save();

    return $product;
  }
}
