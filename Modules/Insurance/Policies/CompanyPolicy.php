<?php
namespace Modules\Insurance\Policies;

use Modules\Insurance\Entities\Company;
    use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
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
return $user->hasPermissionTo('companies.index');
}

/**
* Determine whether the user can view the model.
*
* @param  \App\Models\User  $user
* @param  Company  $company
* @return mixed
*/
public function view(User $user, Company $company)
{
return $user->hasPermissionTo('companies.show');
}

/**
* Determine whether the user can create models.
*
* @param  \App\Models\User  $user
* @return mixed
*/
public function create(User $user)
{
return $user->hasPermissionTo('companies.create');
}

/**
* Determine whether the user can update the model.
*
* @param  \App\Models\User  $user
* @param  Company  $company
* @return mixed
*/
public function update(User $user, Company $company)
{
return $user->hasPermissionTo('companies.edit');
}

/**
* Determine whether the user can delete the model.
*
* @param  \App\Models\User  $user
* @param  Company  $company
* @return mixed
*/
public function delete(User $user, Company $company)
{
return $user->hasPermissionTo('companies.delete');
}

/**
* Determine whether the user can restore the model.
*
* @param  \App\Models\User  $user
* @param  Company  $company
* @return mixed
*/
public function restore(User $user, Company $company)
{
return false;
}

/**
* Determine whether the user can permanently delete the model.
*
* @param  \App\Models\User  $user
* @param  Company  $company
* @return mixed
*/
public function forceDelete(User $user, Company $company)
{
return $user->hasPermissionTo('companies.delete');
}
}
