<?php
namespace App\Policies;

use App\Models\Admin;
use Illuminate\Foundation\Auth\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class AdminPolicy
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
            return $user->hasPermissionTo('admins.index');
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  Admin  $admin
     * @return mixed
     */
    public function view(AuthUser $user, Admin $admin)
    {
        try {
            return $user->hasPermissionTo('admins.show');
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
            return $user->hasPermissionTo('admins.create');
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  Admin  $admin
     * @return mixed
     */
    public function update(AuthUser $user, Admin $admin)
    {
        try {
            return $user->hasPermissionTo('admins.edit');
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  Admin  $admin
     * @return mixed
     */
    public function delete(AuthUser $user, Admin $admin)
    {
        try {
            return $user->hasPermissionTo('admins.delete');
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  Admin  $admin
     * @return mixed
     */
    public function restore(AuthUser $user, Admin $admin)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  Illuminate\Foundation\Auth\User  $user
     * @param  Admin  $admin
     * @return mixed
     */
    public function forceDelete(AuthUser $user, Admin $admin)
    {
        try {
            return $user->hasPermissionTo('admins.delete');
        } catch (\Throwable $th) {
            return false;
        }
    }
}
