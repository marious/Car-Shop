<?php
namespace Modules\Insurance\Policies;

use Modules\Insurance\Entities\CompanyPrice;
    use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPricePolicy
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
return $user->hasPermissionTo('company-prices.index');
}

/**
* Determine whether the user can view the model.
*
* @param  \App\Models\User  $user
* @param  CompanyPrice  $companyPrice
* @return mixed
*/
public function view(User $user, CompanyPrice $companyPrice)
{
return $user->hasPermissionTo('company-prices.show');
}

/**
* Determine whether the user can create models.
*
* @param  \App\Models\User  $user
* @return mixed
*/
public function create(User $user)
{
return $user->hasPermissionTo('company-prices.create');
}

/**
* Determine whether the user can update the model.
*
* @param  \App\Models\User  $user
* @param  CompanyPrice  $companyPrice
* @return mixed
*/
public function update(User $user, CompanyPrice $companyPrice)
{
return $user->hasPermissionTo('company-prices.edit');
}

/**
* Determine whether the user can delete the model.
*
* @param  \App\Models\User  $user
* @param  CompanyPrice  $companyPrice
* @return mixed
*/
public function delete(User $user, CompanyPrice $companyPrice)
{
return $user->hasPermissionTo('company-prices.delete');
}

/**
* Determine whether the user can restore the model.
*
* @param  \App\Models\User  $user
* @param  CompanyPrice  $companyPrice
* @return mixed
*/
public function restore(User $user, CompanyPrice $companyPrice)
{
return false;
}

/**
* Determine whether the user can permanently delete the model.
*
* @param  \App\Models\User  $user
* @param  CompanyPrice  $companyPrice
* @return mixed
*/
public function forceDelete(User $user, CompanyPrice $companyPrice)
{
return $user->hasPermissionTo('company-prices.delete');
}
}
