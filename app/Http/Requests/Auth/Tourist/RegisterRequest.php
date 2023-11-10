<?php

namespace App\Http\Requests\Auth\Tourist;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => ['string', 'max:255', 'required'],
            'last_name' => ['string', 'max:255', 'required'],
            'email' => ['string', 'email', 'unique:tourists', 'max:255', 'required'],
            'gender' => ['string', 'required'],
            'birthday' => ['string', 'required'],
            'contact_number' => ['string', 'min:11', 'max:12', 'required'],
            'password' => ['string', 'min:6', 'required'],
            'complete_address' => ['string', 'required']
        ];
    }
}
