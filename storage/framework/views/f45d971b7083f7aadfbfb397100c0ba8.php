<?php echo "<?php"
?>

namespace App\Http\Requests\<?php echo e($modelWithNamespaceFromDefault); ?>;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use <?php echo e($modelFullName); ?>;
class Store<?php echo e($modelBaseName); ?> extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * <?php echo e('@'); ?>return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create',<?php echo e($modelBaseName); ?>::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * <?php echo e('@'); ?>return array
     */
    public function rules(): array
    {
        return [
            <?php $__currentLoopData = $standardColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if(!($column['name'] == "updated_by_admin_user_id" || $column['name'] == "created_by_admin_user_id" )): ?>'<?php echo e($column['name']); ?>' => [<?php echo implode(', ', (array) $column['serverStoreRules']); ?>],
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if(count($relations)): ?>
    <?php if(isset($relations["belongsToMany"]) && count($relations['belongsToMany'])): ?>

            <?php $__currentLoopData = $relations['belongsToMany']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $belongsToMany): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>'<?php echo e($belongsToMany['related_table']); ?>' => [<?php echo implode(', ', ['\'array\'']); ?>],
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
    <?php if(isset($relations["belongsTo"]) && count($relations['belongsTo'])): ?>

            <?php $__currentLoopData = $relations['belongsTo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $belongsTo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
'<?php echo e($belongsTo['relationship_variable']); ?>' => [<?php echo implode(', ', array_merge(
    ['\'array\''], collect($relatableColumns[$belongsTo['foreign_key']]['serverStoreRules'])->reject(function($rule){return str_contains($rule,'integer');})->toArray()
)); ?>],
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<?php endif; ?>
            'password_confirmation' =>  ['required','same:password'],
            'assigned_roles' => ["required","array"],
        ];
    }
    /**
    * Modify input data
    *
    * <?php echo e('@'); ?>return array
    */
    public function sanitizedArray(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }
    /**
    * Return modified (sanitized data) as a php object
    * @return object
    */
    public function sanitizedObject(): object {
        $sanitized = $this->sanitizedArray();
        return json_decode(collect($sanitized));
    }
}
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/user/store-request.blade.php ENDPATH**/ ?>