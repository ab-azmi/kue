<?php

namespace App\Http\Requests\Cake;

use App\Rules\ValidUnit;
use GlobalXtreme\Validation\Support\FormRequest;

class CakeComponentIngredientRequest extends FormRequest
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
            'unitId' => ['required', 'numeric', new ValidUnit],
            'price' => 'required|numeric',
            'expirationDate' => 'required|date',
            'quantity' => 'required|integer',
            'supplier' => 'nullable|string|max:255',
        ];
    }
}
