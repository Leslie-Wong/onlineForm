<?php
namespace App\Policies;

use App\Models\FormAttribute;
use Illuminate\Foundation\Auth\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormAttributePolicy
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
        return $user->hasPermissionTo('form-attributes.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  FormAttribute  $formAttribute
     * @return mixed
     */
    public function view(User $user, FormAttribute $formAttribute)
    {
        return $user->hasPermissionTo('form-attributes.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('form-attributes.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  FormAttribute  $formAttribute
     * @return mixed
     */
    public function update(User $user, FormAttribute $formAttribute)
    {
        return $user->hasPermissionTo('form-attributes.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  FormAttribute  $formAttribute
     * @return mixed
     */
    public function delete(User $user, FormAttribute $formAttribute)
    {
        return $user->hasPermissionTo('form-attributes.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  FormAttribute  $formAttribute
     * @return mixed
     */
    public function restore(User $user, FormAttribute $formAttribute)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  FormAttribute  $formAttribute
     * @return mixed
     */
    public function forceDelete(User $user, FormAttribute $formAttribute)
    {
        return $user->hasPermissionTo('form-attributes.delete');
    }
}
