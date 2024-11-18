<?php

namespace App\Http\Requests\Ingridient;

use GlobalXtreme\Validation\Support\FormRequest;

class IngridientRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'pricePerUnit' => 'required|numeric',
            'expirationDate' => 'required|date',
            'quantity' => 'required|integer',
            'supplier' => 'nullable|string|max:255',
        ];
    }
}
