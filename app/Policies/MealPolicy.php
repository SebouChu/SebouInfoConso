<?php

namespace App\Policies;

use App\User;
use App\Meal;
use Illuminate\Auth\Access\HandlesAuthorization;

class MealPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the meal.
     *
     * @param  \App\User  $user
     * @param  \App\Meal  $meal
     * @return mixed
     */
    public function view(User $user, Meal $meal)
    {
        return $user->id === $meal->user_id;
    }

    /**
     * Determine whether the user can manage the meal.
     *
     * @param  \App\User  $user
     * @param  \App\Meal  $meal
     * @return mixed
     */
    public function manage(User $user, Meal $meal)
    {
        return $user->id === $meal->user_id;
    }
}
