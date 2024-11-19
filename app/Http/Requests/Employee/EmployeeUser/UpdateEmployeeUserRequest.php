<?php

namespace App\Http\Requests\Employee\EmployeeUser;

use GlobalXtreme\Validation\Support\FormRequest;

class UpdateEmployeeUserRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:255', 'unique:employee_users,email,' . $this->id],
        ];
    }
}