<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatsController extends Controller
{
    public function __construct() {
      $this->middleware('auth');
    }

    public function index() {
      $mostEnergizingConsumedProducts = Auth::user()->distinctConsumedProducts()
                                                    ->orderBy('energy', 'desc')
                                                    ->limit(5)
                                                    ->get();

      $leastEnergizingConsumedProducts = Auth::user()->distinctConsumedProducts()
                                                     ->orderBy('energy', 'asc')
                                                     ->limit(5)
                                                     ->get();

      $mostEnergizingProductsByTotalConsumed = Auth::user()->consumedProducts()
                                                           ->groupBy('id')
                                                           ->selectRaw('SUM(`products`.`energy` * `meal_product`.`quantity`) as totalEnergy, SUM(`meal_product`.`quantity`) as consumedCount')
                                                           ->orderBy('totalEnergy', 'desc')
                                                           ->limit(5)
                                                           ->get();

      return view('stats', compact('mostEnergizingConsumedProducts', 'leastEnergizingConsumedProducts', 'mostEnergizingProductsByTotalConsumed'));
    }
}
