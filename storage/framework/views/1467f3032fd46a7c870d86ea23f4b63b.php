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
            'title' => ['required', 'string',Rule::unique('roles')->where('guard_name','web')],
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
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/role/store-request.blade.php ENDPATH**/ ?>