<?php

namespace App\Http\Requests\Cake;

use GlobalXtreme\Validation\Support\FormRequest;

class CakeRequest extends FormRequest
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
            'stock' => 'required|numeric|max:255',
            'profitMargin' => 'nullable|string|max:255',
            'COGS' => 'nullable|numeric|max:255',
            'sellingPrice' => 'nullable|numeric',

            'images' => 'array',
            'images.*.file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'images.*.mimeType' => 'string|max:255',
            'images.*.url' => 'string|max:255',

            'ingredients' => 'array',
            'ingredients.*.ingredientId' => 'numeric|max:255',
            'ingredients.*.quantity' => 'numeric|max:255',
        ];
    }
}
