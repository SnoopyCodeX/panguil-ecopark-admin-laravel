<?php

namespace App\Http\Requests\Tourist;

use Illuminate\Foundation\Http\FormRequest;

class CancelOrUpdateReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('tourist')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'action' => ['string', 'required', 'in:cancel_reservation,update_reservation'],
            'reservation_id' => ['required', 'integer', 'exists:available_reservations,id'],
            'number_of_adults' => ['required', 'integer'],
            'number_of_children' => ['required', 'integer'],
            'reserve_date' => ['required', 'string'],
            'arrival_time' => ['required', 'string'],
            'phone_number' => ['required', 'string', 'min:11', 'max:12'],
        ];
    }
}
