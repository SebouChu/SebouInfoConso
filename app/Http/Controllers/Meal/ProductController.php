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
    $this->authorize('manage', $meal);

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
    $this->authorize('manage', $meal);

    $attributes = $request->validate([
      'barcode' => 'required',
      'quantity' => 'required|integer|min:1'
    ]);

    $product = $productFinder->search($attributes['barcode']);
    $quantity = $attributes['quantity'];

    if ($product === null) {
      return redirect()->back()
                       ->withInput($request->input())
                       ->with('alert', 'Product not found.');
    }

    if ($meal->products->contains($product->id)) {
      Session::flash('alert', 'Your meal already contains this product.');
    } else {
      $meal->products()->attach($product, compact('quantity'));
      Session::flash('notice', 'Product was successfully added to your meal!');
    }

    return redirect()->route('meals.show', $meal->id);
  }

  public function edit(Meal $meal, Product $product) {
    $this->authorize('manage', $meal);

    if (!$meal->products->contains($product->id)) {
      return redirect()->route('meals.show', $meal->id)
                       ->with('alert', 'Your meal doesn\'t contain this product.');
    }

    $quantity = $meal->products()
                     ->where('id', $product->id)
                     ->pluck('meal_product.quantity')
                     ->first();

    return view('meals/products/edit', compact('meal', 'product', 'quantity'));
  }

  public function update(Request $request, Meal $meal, Product $product) {
    $this->authorize('manage', $meal);

    if (!$meal->products->contains($product->id)) {
      return redirect()->route('meals.show', $meal->id)
                       ->with('alert', 'Your meal doesn\'t contain this product.');
    }

    $attributes = $request->validate([
      'quantity' => 'required|integer|min:1'
    ]);
    $quantity = $attributes["quantity"];

    $meal->products()->updateExistingPivot($product->id, compact('quantity'));

    return redirect()->route('meals.show', $meal->id)
                     ->with('notice', 'Product successfully updated!');
  }

  public function destroy(Meal $meal, Product $product) {
    $this->authorize('manage', $meal);

    $meal->products()->detach($product);
    Session::flash('notice', 'Product was successfully deleted from your meal!');

    return redirect()->route('meals.show', $meal->id);
  }
}
