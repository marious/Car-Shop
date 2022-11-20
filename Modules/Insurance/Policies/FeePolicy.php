<?php
namespace Modules\Insurance\Policies;

use Modules\Insurance\Entities\Fee;
    use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeePolicy
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
return $user->hasPermissionTo('fees.index');
}

/**
* Determine whether the user can view the model.
*
* @param  \App\Models\User  $user
* @param  Fee  $fee
* @return mixed
*/
public function view(User $user, Fee $fee)
{
return $user->hasPermissionTo('fees.show');
}

/**
* Determine whether the user can create models.
*
* @param  \App\Models\User  $user
* @return mixed
*/
public function create(User $user)
{
return $user->hasPermissionTo('fees.create');
}

/**
* Determine whether the user can update the model.
*
* @param  \App\Models\User  $user
* @param  Fee  $fee
* @return mixed
*/
public function update(User $user, Fee $fee)
{
return $user->hasPermissionTo('fees.edit');
}

/**
* Determine whether the user can delete the model.
*
* @param  \App\Models\User  $user
* @param  Fee  $fee
* @return mixed
*/
public function delete(User $user, Fee $fee)
{
return $user->hasPermissionTo('fees.delete');
}

/**
* Determine whether the user can restore the model.
*
* @param  \App\Models\User  $user
* @param  Fee  $fee
* @return mixed
*/
public function restore(User $user, Fee $fee)
{
return false;
}

/**
* Determine whether the user can permanently delete the model.
*
* @param  \App\Models\User  $user
* @param  Fee  $fee
* @return mixed
*/
public function forceDelete(User $user, Fee $fee)
{
return $user->hasPermissionTo('fees.delete');
}
}
