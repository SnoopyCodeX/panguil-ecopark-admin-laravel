<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddNewTouristRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (auth()->check() && auth()->user()->type == 'admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'tourist_name' => ['string', 'required', 'max:50'],
            'gender' => ['string', 'required'],
            'age' => ['integer', 'required'],
            'cellphone_number' => ['string', 'required', 'min:11', 'max:12'],
            'assign_datetime' => ['string', 'required'],
        ];
    }
}
