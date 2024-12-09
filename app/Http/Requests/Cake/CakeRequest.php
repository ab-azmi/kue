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
            'isSell' => 'required|boolean',
            'stockSell' => 'nullable|numeric',
            'stockNonSell' => 'nullable|numeric',
            'profitMargin' => 'nullable|numeric',
            'COGS' => 'nullable|numeric',
            'sellingPrice' => 'nullable|numeric',

            'images' => 'array',
            'images.*.file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'images.*.mime' => 'string|max:255',
            'images.*.path' => 'string|max:255',

            'ingredients' => 'array',
            'ingredients.*.id' => 'numeric|max:255',
            'ingredients.*.quantity' => 'numeric|max:255',
        ];
    }
}
