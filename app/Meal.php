<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Meal extends Model
{
    public function user() {
      return $this->belongsTo(User::class);
    }

    public function products()
    {
      return $this->belongsToMany(Product::class);
    }

    public function formattedDate() {
      return Carbon::parse($this->date)->toFormattedDateString();
    }
}
