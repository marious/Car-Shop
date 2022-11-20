<?php
namespace Modules\Insurance\Policies;

use Modules\Insurance\Entities\Price;
    use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PricePolicy
{
use HandlesAuthorization;

/**
* Determine whether the user can view any models.
*
* @param  \App\Models\User  $user
* @return mixed
*/
public function viewAny(User $user)
{
return $user->hasPermissionTo('prices.index');
}

/**
* Determine whether the user can view the model.
*
* @param  \App\Models\User  $user
* @param  Price  $price
* @return mixed
*/
public function view(User $user, Price $price)
{
return $user->hasPermissionTo('prices.show');
}

/**
* Determine whether the user can create models.
*
* @param  \App\Models\User  $user
* @return mixed
*/
public function create(User $user)
{
return $user->hasPermissionTo('prices.create');
}

/**
* Determine whether the user can update the model.
*
* @param  \App\Models\User  $user
* @param  Price  $price
* @return mixed
*/
public function update(User $user, Price $price)
{
return $user->hasPermissionTo('prices.edit');
}

/**
* Determine whether the user can delete the model.
*
* @param  \App\Models\User  $user
* @param  Price  $price
* @return mixed
*/
public function delete(User $user, Price $price)
{
return $user->hasPermissionTo('prices.delete');
}

/**
* Determine whether the user can restore the model.
*
* @param  \App\Models\User  $user
* @param  Price  $price
* @return mixed
*/
public function restore(User $user, Price $price)
{
return false;
}

/**
* Determine whether the user can permanently delete the model.
*
* @param  \App\Models\User  $user
* @param  Price  $price
* @return mixed
*/
public function forceDelete(User $user, Price $price)
{
return $user->hasPermissionTo('prices.delete');
}
}
