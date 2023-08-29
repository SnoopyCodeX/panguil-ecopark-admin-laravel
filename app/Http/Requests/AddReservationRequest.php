<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return ($this->method() == 'POST' && auth()->check() && auth()->user()->type == 'admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'gender' => ['required', 'string', 'in:male,female'],
            'age' => ['required', 'integer'],
            'contact_number' => ['required', 'string', 'max:12', 'min:11'],
            'number_of_tourist' => ['required', 'integer'],
            // 'assigned_reservation_datetime' => ['required', 'string'],
            'tour_guide_name' => ['required', 'string'],
        ];
    }
}
