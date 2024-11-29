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
            'email' => 'required|email',
            'password' => 'required|string|min:5',
            'role' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'bankNumber' => 'nullable|string|max:255',
            'totalSalary' => 'nullable|numeric',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ];
    }
}
