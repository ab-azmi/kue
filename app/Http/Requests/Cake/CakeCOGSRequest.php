<?php

namespace App\Http\Requests\Cake;

use GlobalXtreme\Validation\Support\FormRequest;

class CakeCOGSRequest extends FormRequest
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
            'ingridients.*.id' => 'required|exists:cake_component_ingridients,id',
            'ingridients.*.quantity' => 'required|numeric',
        ];
    }
}
