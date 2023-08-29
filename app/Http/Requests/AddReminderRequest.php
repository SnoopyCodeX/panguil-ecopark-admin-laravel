<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddReminderRequest extends FormRequest
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
            'reminder-content' => ['required', 'string', 'max:100'],
        ];
    }
}
