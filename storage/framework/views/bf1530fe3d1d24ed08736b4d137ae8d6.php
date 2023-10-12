<?php echo "<?php"
?>


namespace App\Http\Requests\<?php echo e($modelWithNamespaceFromDefault); ?>;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use <?php echo e($modelFullName); ?>;
class Index<?php echo e($modelBaseName); ?> extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * <?php echo e('@'); ?>return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('viewAny',<?php echo e($modelBaseName); ?>::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * <?php echo e('@'); ?>return array
     */
    public function rules(): array
    {
        return [
            'search' => 'string|nullable',
            'page' => 'integer|nullable',
            'per_page' => 'integer|nullable',
        ];
    }
}
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/role/index-request.blade.php ENDPATH**/ ?>