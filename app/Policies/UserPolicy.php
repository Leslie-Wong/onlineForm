<?php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  Illuminate\Foundation\Auth\Userr  $user
     * @return mixed
     */
    public function viewAny(AuthUser $user)
    {
        try {
            return $user->hasPermissionTo('users.index');
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  User  $model
     * @return mixed
     */
    public function view(AuthUser $user, User $model)
    {
        try {
            return $user->hasPermissionTo('users.show');
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @return mixed
     */
    public function create(AuthUser $user)
    {
        try {
            return $user->hasPermissionTo('users.create');
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  User  $model
     * @return mixed
     */
    public function update(AuthUser $user, User $model)
    {
        try {
            return $user->hasPermissionTo('users.edit');
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  User  $model
     * @return mixed
     */
    public function delete(AuthUser $user, User $model)
    {
        try {
            return $user->hasPermissionTo('users.delete');
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  User  $model
     * @return mixed
     */
    public function restore(AuthUser $user, User $model)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  User  $model
     * @return mixed
     */
    public function forceDelete(AuthUser $user, User $model)
    {
        try {
            return $user->hasPermissionTo('users.delete');
        } catch (\Throwable $th) {
            return false;
        }
    }
}
