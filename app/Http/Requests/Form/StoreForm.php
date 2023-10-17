<?php
namespace App\Http\Requests\Form;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use App\Models\Form;
class StoreForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // return $this->user()->can('create',Form::class);
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {

        $childList = [];

        if(isset($this->form_attributes)){
            for ($i=0; $i < count($this->form_attributes); $i++) {
                if(isset($this->form_attributes[$i]['lang'])){
                    if (false !== $key = array_search($this->form_attributes[$i]['lang'], $childList)) {
                        $error = \Illuminate\Validation\ValidationException::withMessages([
                            'form_attributes.'.$i.'.lang' => __('validation.unique'),
                            'form_attributes.'.$key.'.lang' => __('validation.unique'),
                         ]);
                        throw $error;
                    } else {
                        $childList[] = $this->form_attributes[$i]['lang'];
                    }
                }
            }
        }

        $user = [
            'form_attributes.*.name' => ['required', 'string'],
            'form_attributes.*.phone' => ['required', 'string'],
            'form_attributes.*.email' => ['required', 'email', 'string'],
        ];
        if( auth('sanctum')->check() ){
            $user = [];
        }


        return [
                'form_attributes' => ['array','min:1'],
                ...$user,
                'form_attributes.*.product_sku' => ['nullable', 'string'],
                'form_attributes.*.product_name' => ['required', 'string'],
                'form_attributes.*.product_type' => ['nullable', 'string'],
                'form_attributes.*.brand' => ['nullable', 'string'],
                'form_attributes.*.ref_price' => ['nullable', 'string'],
                'form_attributes.*.place_of_origin' => ['nullable', 'string'],
                'form_attributes.*.product_details' => ['nullable', 'string'],
                'form_attributes.*.product_image' => ['nullable', 'max:'.\Config::get('jetin.maxUpload', 10000)],




        ];
    }
    /**
    * Modify input data
    *
    * @return array
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
