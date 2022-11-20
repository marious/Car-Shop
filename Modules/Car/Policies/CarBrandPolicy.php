<?php
namespace Modules\Car\Policies;

use Modules\Car\Entities\CarBrand;
    use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarBrandPolicy
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
return $user->hasPermissionTo('car-brands.index');
}

/**
* Determine whether the user can view the model.
*
* @param  \App\Models\User  $user
* @param  CarBrand  $carBrand
* @return mixed
*/
public function view(User $user, CarBrand $carBrand)
{
return $user->hasPermissionTo('car-brands.show');
}

/**
* Determine whether the user can create models.
*
* @param  \App\Models\User  $user
* @return mixed
*/
public function create(User $user)
{
return $user->hasPermissionTo('car-brands.create');
}

/**
* Determine whether the user can update the model.
*
* @param  \App\Models\User  $user
* @param  CarBrand  $carBrand
* @return mixed
*/
public function update(User $user, CarBrand $carBrand)
{
return $user->hasPermissionTo('car-brands.edit');
}

/**
* Determine whether the user can delete the model.
*
* @param  \App\Models\User  $user
* @param  CarBrand  $carBrand
* @return mixed
*/
public function delete(User $user, CarBrand $carBrand)
{
return $user->hasPermissionTo('car-brands.delete');
}

/**
* Determine whether the user can restore the model.
*
* @param  \App\Models\User  $user
* @param  CarBrand  $carBrand
* @return mixed
*/
public function restore(User $user, CarBrand $carBrand)
{
return false;
}

/**
* Determine whether the user can permanently delete the model.
*
* @param  \App\Models\User  $user
* @param  CarBrand  $carBrand
* @return mixed
*/
public function forceDelete(User $user, CarBrand $carBrand)
{
return $user->hasPermissionTo('car-brands.delete');
}
}
