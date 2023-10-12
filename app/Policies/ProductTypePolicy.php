<?php
namespace App\Policies;

use App\Models\ProductType;
use Illuminate\Foundation\Auth\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductTypePolicy
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
        return $user->hasPermissionTo('product-types.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  ProductType  $productType
     * @return mixed
     */
    public function view(User $user, ProductType $productType)
    {
        return $user->hasPermissionTo('product-types.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('product-types.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  ProductType  $productType
     * @return mixed
     */
    public function update(User $user, ProductType $productType)
    {
        return $user->hasPermissionTo('product-types.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  ProductType  $productType
     * @return mixed
     */
    public function delete(User $user, ProductType $productType)
    {
        return $user->hasPermissionTo('product-types.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  ProductType  $productType
     * @return mixed
     */
    public function restore(User $user, ProductType $productType)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  ProductType  $productType
     * @return mixed
     */
    public function forceDelete(User $user, ProductType $productType)
    {
        return $user->hasPermissionTo('product-types.delete');
    }
}
