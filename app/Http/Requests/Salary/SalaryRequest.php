<?php

namespace App\Http\Requests\Salary;

use GlobalXtreme\Validation\Support\FormRequest;

class SalaryRequest extends FormRequest
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
            'basic_salary' => ['required', 'numeric'],
            'tax' => ['nullable', 'string'],
            'overtime' => ['nullable', 'numeric'],
            'total_salary' => ['nullable', 'numeric'],
            'user_id' => ['nullable', 'numeric'],
        ];
    }
}
