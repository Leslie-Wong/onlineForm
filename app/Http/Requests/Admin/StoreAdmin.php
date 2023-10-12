<?php
namespace App\Http\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use App\Models\Admin;
class StoreAdmin extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create',Admin::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('admin', 'email'), 'string'],
            'email_verified_at' => ['nullable', 'string'],
            'password' => ['required', 'confirmed', 'min:7', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/', 'string'],
            'lang' => ['required', 'string'],
            'two_factor_secret' => ['nullable', 'string'],
            'two_factor_recovery_codes' => ['nullable', 'string'],
            'two_factor_confirmed_at' => ['nullable', 'string'],
            'current_team_id' => ['nullable', 'integer'],
            'profile_photo_path' => ['nullable', 'max:'.\Config::get('jetin.maxUpload', 10000)],
                                'password_confirmation' =>  ['required','same:password'],
            'assigned_roles' => ["required","array"],
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
