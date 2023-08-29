<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer'],
            'cellphone_number' => ['required', 'string', 'min:11', 'max:12'],
            'email' => ['required', 'unique:users', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The first name field is required.',
            'age.required' => 'The age field is required.',
            'age.integer' => 'The age must be an integer.',
            'cellphone_number.required' => 'The cellphone number field is required.',
            'cellphone_number.min' => 'The cellphone number must be at least :min characters.',
            'cellphone_number.max' => 'The cellphone number may not be greater than :max characters.',
            'email.required' => 'The email address field is required.',
            'email.unique' => 'The email address is already in use.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least :min characters.',
        ];
    }
}
