<?php
namespace Modules\Car\Policies;

use Modules\Car\Entities\CarModel;
    use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarModelPolicy
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
return $user->hasPermissionTo('car-models.index');
}

/**
* Determine whether the user can view the model.
*
* @param  \App\Models\User  $user
* @param  CarModel  $carModel
* @return mixed
*/
public function view(User $user, CarModel $carModel)
{
return $user->hasPermissionTo('car-models.show');
}

/**
* Determine whether the user can create models.
*
* @param  \App\Models\User  $user
* @return mixed
*/
public function create(User $user)
{
return $user->hasPermissionTo('car-models.create');
}

/**
* Determine whether the user can update the model.
*
* @param  \App\Models\User  $user
* @param  CarModel  $carModel
* @return mixed
*/
public function update(User $user, CarModel $carModel)
{
return $user->hasPermissionTo('car-models.edit');
}

/**
* Determine whether the user can delete the model.
*
* @param  \App\Models\User  $user
* @param  CarModel  $carModel
* @return mixed
*/
public function delete(User $user, CarModel $carModel)
{
return $user->hasPermissionTo('car-models.delete');
}

/**
* Determine whether the user can restore the model.
*
* @param  \App\Models\User  $user
* @param  CarModel  $carModel
* @return mixed
*/
public function restore(User $user, CarModel $carModel)
{
return false;
}

/**
* Determine whether the user can permanently delete the model.
*
* @param  \App\Models\User  $user
* @param  CarModel  $carModel
* @return mixed
*/
public function forceDelete(User $user, CarModel $carModel)
{
return $user->hasPermissionTo('car-models.delete');
}
}
