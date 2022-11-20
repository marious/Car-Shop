<?php
namespace Modules\CarShop\Policies;

use Modules\CarShop\Entities\CarShop;
    use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarShopPolicy
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
return $user->hasPermissionTo('car-shops.index');
}

/**
* Determine whether the user can view the model.
*
* @param  \App\Models\User  $user
* @param  CarShop  $carShop
* @return mixed
*/
public function view(User $user, CarShop $carShop)
{
return $user->hasPermissionTo('car-shops.show');
}

/**
* Determine whether the user can create models.
*
* @param  \App\Models\User  $user
* @return mixed
*/
public function create(User $user)
{
return $user->hasPermissionTo('car-shops.create');
}

/**
* Determine whether the user can update the model.
*
* @param  \App\Models\User  $user
* @param  CarShop  $carShop
* @return mixed
*/
public function update(User $user, CarShop $carShop)
{
return $user->hasPermissionTo('car-shops.edit');
}

/**
* Determine whether the user can delete the model.
*
* @param  \App\Models\User  $user
* @param  CarShop  $carShop
* @return mixed
*/
public function delete(User $user, CarShop $carShop)
{
return $user->hasPermissionTo('car-shops.delete');
}

/**
* Determine whether the user can restore the model.
*
* @param  \App\Models\User  $user
* @param  CarShop  $carShop
* @return mixed
*/
public function restore(User $user, CarShop $carShop)
{
return false;
}

/**
* Determine whether the user can permanently delete the model.
*
* @param  \App\Models\User  $user
* @param  CarShop  $carShop
* @return mixed
*/
public function forceDelete(User $user, CarShop $carShop)
{
return $user->hasPermissionTo('car-shops.delete');
}
}
