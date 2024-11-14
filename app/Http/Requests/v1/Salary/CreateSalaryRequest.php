<?php

namespace App\Http\Requests\v1\Salary;

use GlobalXtreme\Validation\Support\FormRequest;

class CreateSalaryRequest extends FormRequest
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
            'basic_salary' => ['required', 'string'],
            'tax' => ['nullable', 'string'],
            'overtime' => ['nullable', 'string'],
            'total_salary' => ['nullable', 'string'],
            'user_id' => ['nullable', 'numeric'],
        ];
    }
}
