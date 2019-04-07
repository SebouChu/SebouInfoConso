<?php

namespace App\Http\Controllers\Meal;

use App\Meal;
use App\Product;
use App\Http\Controllers\Controller;
use App\Services\ProductFinderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function create(Meal $meal) {
    $this->authorize('update', $meal);

    $mealProductsIds = $meal->products()
                            ->pluck('id')
                            ->toArray();

    $products = Product::select('barcode', 'name')->whereNotIn('id', $mealProductsIds)
                                                  ->orderBy('name')
                                                  ->get();

    return view('meals/products/create', [
      'meal' => $meal,
      'products' => $products,
      'product' => new Product()
    ]);
  }

  public function store(Request $request, Meal $meal, ProductFinderService $productFinder) {
    $this->authorize('update', $meal);

    $attributes = $request->validate([
      'barcode' => 'required'
    ]);

    $product = $productFinder->search($attributes['barcode']);
    if ($product === null) {
      return redirect()->back()
                       ->withInput($request->input())
                       ->with('alert', 'Product not found.');
    }

    if ($meal->products->contains($product->id)) {
      Session::flash('alert', 'Your meal already contains this product.');
    } else {
      $meal->products()->attach($product);
      Session::flash('notice', 'Product was successfully added to your meal!');
    }

    return redirect()->route('meals.show', $meal->id);
  }

  public function destroy(Meal $meal, Product $product) {
    $this->authorize('update', $meal);

    $meal->products()->detach($product);
    Session::flash('notice', 'Product was successfully deleted from your meal!');

    return redirect()->route('meals.show', $meal->id);
  }
}
