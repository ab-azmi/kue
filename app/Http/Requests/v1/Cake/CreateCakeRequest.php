<?php

namespace App\Http\Requests\v1\Cake;

use GlobalXtreme\Validation\Support\FormRequest;

class CreateCakeRequest extends FormRequest
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
            'cakeVariantId' => 'required|exists:cake_variants,id',
            'profitMargin' => 'nullable|string|max:255',
            'cogs' => 'nullable|numeric|max:255',
            'sellPrice' => 'nullable|numeric|max:255',
            'images' => 'json',
            'ingridients' => 'array',
            'ingridients.*.id' => 'numeric|max:255',
            'ingridients.*.quantity' => 'numeric|max:255',
        ];
    }
}
