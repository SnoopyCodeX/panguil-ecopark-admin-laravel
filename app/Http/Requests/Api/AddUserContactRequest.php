<?php

namespace App\Http\Requests\Api;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddUserContactRequest extends FormRequest
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
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'contact_name' => ['required', 'string', Rule::unique('user_contacts')->where(function (Builder $query) {
                return $query->where('user_id', $this->user_id);
            })],
            'contact_number' => ['required', 'string'],
            'contact_role' => ['required', 'string'],
        ];
    }

    public function messages() : array
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The specified owner of this contact does not exist.',

            'contact_name.required' => 'The contact name is required.',
            'contact_name.unique' => 'The contact name is already associated with the same owner.',

            'contact_number.required' => 'The contact number is required.',
            'contact_role.required' => 'The contact role is required.',
        ];
    }
}
