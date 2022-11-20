<?php
namespace Modules\Insurance\Policies;

use Modules\Insurance\Entities\CompanyCarModel;
    use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyCarModelPolicy
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
return $user->hasPermissionTo('company-car-models.index');
}

/**
* Determine whether the user can view the model.
*
* @param  \App\Models\User  $user
* @param  CompanyCarModel  $companyCarModel
* @return mixed
*/
public function view(User $user, CompanyCarModel $companyCarModel)
{
return $user->hasPermissionTo('company-car-models.show');
}

/**
* Determine whether the user can create models.
*
* @param  \App\Models\User  $user
* @return mixed
*/
public function create(User $user)
{
return $user->hasPermissionTo('company-car-models.create');
}

/**
* Determine whether the user can update the model.
*
* @param  \App\Models\User  $user
* @param  CompanyCarModel  $companyCarModel
* @return mixed
*/
public function update(User $user, CompanyCarModel $companyCarModel)
{
return $user->hasPermissionTo('company-car-models.edit');
}

/**
* Determine whether the user can delete the model.
*
* @param  \App\Models\User  $user
* @param  CompanyCarModel  $companyCarModel
* @return mixed
*/
public function delete(User $user, CompanyCarModel $companyCarModel)
{
return $user->hasPermissionTo('company-car-models.delete');
}

/**
* Determine whether the user can restore the model.
*
* @param  \App\Models\User  $user
* @param  CompanyCarModel  $companyCarModel
* @return mixed
*/
public function restore(User $user, CompanyCarModel $companyCarModel)
{
return false;
}

/**
* Determine whether the user can permanently delete the model.
*
* @param  \App\Models\User  $user
* @param  CompanyCarModel  $companyCarModel
* @return mixed
*/
public function forceDelete(User $user, CompanyCarModel $companyCarModel)
{
return $user->hasPermissionTo('company-car-models.delete');
}
}
