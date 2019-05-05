<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $recentMeals = Auth::user()->meals()
                                 ->with('products:energy')
                                 ->orderBy('date', 'desc')
                                 ->orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();

      $lastImportedProducts = Product::select('barcode', 'name', 'energy')->orderBy('created_at', 'desc')
                                                                ->limit(5)
                                                                ->get();

      return view('home', compact('recentMeals', 'lastImportedProducts'));
    }
}
