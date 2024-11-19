<?php

namespace App\Http\Requests\Employee\EmployeeUser;

use GlobalXtreme\Validation\Support\FormRequest;

class CreateEmployeeUserRequest extends FormRequest
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
            'email' => 'required|email|unique:employee_users,email',
            'password' => 'required|string|min:5',
            'role' => 'string|max:10'
        ];
    }
}
