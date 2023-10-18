<?php
namespace App\Policies;

use App\Models\Form;
use Illuminate\Foundation\Auth\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormPolicy
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
        return $user->hasPermissionTo('forms.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  Form  $form
     * @return mixed
     */
    public function view(User $user, Form $form)
    {
        return $user->hasPermissionTo('forms.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('forms.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  Form  $form
     * @return mixed
     */
    public function update(User $user, Form $form)
    {
        return $user->hasPermissionTo('forms.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  Form  $form
     * @return mixed
     */
    public function delete(User $user, Form $form)
    {
        return $user->hasPermissionTo('forms.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  Form  $form
     * @return mixed
     */
    public function restore(User $user, Form $form)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  Form  $form
     * @return mixed
     */
    public function forceDelete(User $user, Form $form)
    {
        return $user->hasPermissionTo('forms.delete');
    }
}
