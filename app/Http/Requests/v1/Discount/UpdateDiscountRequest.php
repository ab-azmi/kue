<?php

namespace App\Http\Requests\v1\Discount;

use GlobalXtreme\Validation\Support\FormRequest;

class UpdateDiscountRequest extends FormRequest
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
            'customerName' => 'nullable|string|max:255',
            'quantity' => 'required|default:1',
            'tax' => 'nullable|string',
            'orderPrice' => 'nullable|string',
            'totalPrice' => 'nullable|string',
            'totalDiscount' => 'nullable|string',
            'cashierId' => 'required|exists:users,id',
            'orders' => 'required|array',
            'orders.*.cakeId' => 'required|exists:cakes,id',
            'orders.*.quantity' => 'required|integer',
        ];
    }
}
