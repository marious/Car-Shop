<?php
namespace Modules\Insurance\Policies;

use Modules\Insurance\Entities\CompanyFee;
    use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyFeePolicy
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
return $user->hasPermissionTo('company-fees.index');
}

/**
* Determine whether the user can view the model.
*
* @param  \App\Models\User  $user
* @param  CompanyFee  $companyFee
* @return mixed
*/
public function view(User $user, CompanyFee $companyFee)
{
return $user->hasPermissionTo('company-fees.show');
}

/**
* Determine whether the user can create models.
*
* @param  \App\Models\User  $user
* @return mixed
*/
public function create(User $user)
{
return $user->hasPermissionTo('company-fees.create');
}

/**
* Determine whether the user can update the model.
*
* @param  \App\Models\User  $user
* @param  CompanyFee  $companyFee
* @return mixed
*/
public function update(User $user, CompanyFee $companyFee)
{
return $user->hasPermissionTo('company-fees.edit');
}

/**
* Determine whether the user can delete the model.
*
* @param  \App\Models\User  $user
* @param  CompanyFee  $companyFee
* @return mixed
*/
public function delete(User $user, CompanyFee $companyFee)
{
return $user->hasPermissionTo('company-fees.delete');
}

/**
* Determine whether the user can restore the model.
*
* @param  \App\Models\User  $user
* @param  CompanyFee  $companyFee
* @return mixed
*/
public function restore(User $user, CompanyFee $companyFee)
{
return false;
}

/**
* Determine whether the user can permanently delete the model.
*
* @param  \App\Models\User  $user
* @param  CompanyFee  $companyFee
* @return mixed
*/
public function forceDelete(User $user, CompanyFee $companyFee)
{
return $user->hasPermissionTo('company-fees.delete');
}
}
