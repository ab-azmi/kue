<?php

namespace App\Http\Requests\Cake;

use GlobalXtreme\Validation\Support\FormRequest;

class CakeDiscountRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'nullable|string',
            'fromDate' => 'required|string',
            'toDate' => 'required|string',
            'value' => 'required|integer',
            'cakeId' => 'required|integer|exists:cakes,id',
        ];
    }
}
