<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public function meals() {
      return $this->hasMany(Meal::class);
    }

    public function consumedProducts() {
      return Meal::join('meal_product', 'meal_product.meal_id', '=', 'meals.id')
                 ->join('products', 'meal_product.product_id', '=', 'products.id')
                 ->select('products.*', 'meal_product.quantity')
                 ->where('meals.user_id', $this->id);
    }

    public function distinctConsumedProducts() {
      return $this->consumedProducts()->distinct();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
