<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignTourGuideRequest extends FormRequest
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
            'tour_guide_name' => ['string', 'required'],
            'assigned_datetime' => ['string', 'required'],
            'tourist_name' => ['string', 'required'],
            'age' => ['integer', 'required'],
            'gender' => ['string', 'required'],
            'cellphone_number' => ['string', 'required', 'min:11', 'max:12'],
        ];
    }
}
