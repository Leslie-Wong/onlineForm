<?php echo "<?php\n";
if ($modelVariableName === 'user') $modelVariableName = 'model';
?>
namespace <?php echo e($policyNamespace); ?>;

use <?php echo e($modelFullName); ?>;
<?php if($modelVariableName!=='model'): ?>
use Illuminate\Foundation\Auth\User;
<?php endif; ?>
use Illuminate\Auth\Access\HandlesAuthorization;

class <?php echo e($policyBaseName); ?>

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
        return $user->hasPermissionTo('<?php echo e($modelDotNotation); ?>.index');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  <?php echo e($modelBaseName); ?>  $<?php echo e($modelVariableName); ?>

     * @return mixed
     */
    public function view(User $user, <?php echo e($modelBaseName); ?> $<?php echo e($modelVariableName); ?>)
    {
        return $user->hasPermissionTo('<?php echo e($modelDotNotation); ?>.show');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  <?php echo e($modelBaseName); ?>  $<?php echo e($modelVariableName); ?>

     * @return mixed
     */
    public function update(User $user, <?php echo e($modelBaseName); ?> $<?php echo e($modelVariableName); ?>)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  <?php echo e($modelBaseName); ?>  $<?php echo e($modelVariableName); ?>

     * @return mixed
     */
    public function delete(User $user, <?php echo e($modelBaseName); ?> $<?php echo e($modelVariableName); ?>)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  <?php echo e($modelBaseName); ?>  $<?php echo e($modelVariableName); ?>

     * @return mixed
     */
    public function restore(User $user, <?php echo e($modelBaseName); ?> $<?php echo e($modelVariableName); ?>)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  <?php echo e($modelBaseName); ?>  $<?php echo e($modelVariableName); ?>

     * @return mixed
     */
    public function forceDelete(User $user, <?php echo e($modelBaseName); ?> $<?php echo e($modelVariableName); ?>)
    {
        return false;
    }
}
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/permission/policy.blade.php ENDPATH**/ ?>