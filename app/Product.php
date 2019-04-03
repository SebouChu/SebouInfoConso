<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function meals()
    {
        return $this->belongsToMany(Meal::class);
    }

    public function getRouteKeyName()
    {
        return "barcode";
    }
}
