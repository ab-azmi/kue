<?php

namespace App\Http\Requests\v1\Cake;

use GlobalXtreme\Validation\Support\FormRequest;

class COGSRequest extends FormRequest
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
            'volume' => 'required|numeric',
            'margin' => 'nullable|string',
            'ingridients' => 'required|array',
            'ingridients.*.id' => 'required|exists:ingridients,id',
            'ingridients.*.quantity' => 'required|numeric',
        ];
    }
}
