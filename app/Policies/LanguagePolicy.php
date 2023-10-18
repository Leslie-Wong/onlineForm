<?php
namespace App\Policies;

use App\Models\Language;
use Illuminate\Foundation\Auth\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LanguagePolicy
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
        try {
            return $user->hasPermissionTo('languages.index');
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  Language  $language
     * @return mixed
     */
    public function view(User $user, Language $language)
    {
        try {
            return $user->hasPermissionTo('languages.show');
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        try {
            return $user->hasPermissionTo('languages.create');
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  Language  $language
     * @return mixed
     */
    public function update(User $user, Language $language)
    {
        try {
            return $user->hasPermissionTo('languages.edit');
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  Language  $language
     * @return mixed
     */
    public function delete(User $user, Language $language)
    {
        try {
            return $user->hasPermissionTo('languages.delete');
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  Language  $language
     * @return mixed
     */
    public function restore(User $user, Language $language)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  Language  $language
     * @return mixed
     */
    public function forceDelete(User $user, Language $language)
    {
        try {
            return $user->hasPermissionTo('languages.delete');
        } catch (\Throwable $th) {
            return false;
        }
    }
}
