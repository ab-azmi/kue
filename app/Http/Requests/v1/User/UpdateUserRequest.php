<?php

namespace App\Http\Requests\v1\User;

use GlobalXtreme\Validation\Support\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:2',
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $this->id],
        ];
    }
}
