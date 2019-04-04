<?php

namespace App\Http\Controllers;

use App\Product;

class ProductController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index() {
    return view('products/index', [
      'products' => Product::select('barcode', 'name')->orderBy('name', 'asc')->get()
    ]);
  }

  public function show(Product $product) {
    return view('products/show', compact('product'));
  }
}
