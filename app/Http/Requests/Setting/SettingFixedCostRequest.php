<?php

namespace App\Http\Requests\Setting;

use App\Rules\ValidFrequency;
use GlobalXtreme\Validation\Support\FormRequest;

class SettingFixedCostRequest extends FormRequest
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
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'frequencyId' => ['required', 'numeric', new ValidFrequency],
        ];
    }
}
