<?php

namespace App\Http\Requests\Employee;

use GlobalXtreme\Validation\Support\FormRequest;

class EmployeeRequest extends FormRequest
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
            //ignore existing own email
            'email' => 'required|email',
            'password' => 'required|string|min:5',
            'role' => 'nullable|string|max:10',

            'phone' => ['nullable', 'string', 'max:15'],
            'address' => ['nullable', 'string', 'max:255'],
            'bankNumber' => ['nullable', 'string', 'max:255'],

            'totalSalary' => ['nullable', 'numeric'],
            'employeeId' => ['nullable', 'numeric', 'exists:employees,id'],
        ];
    }
}
