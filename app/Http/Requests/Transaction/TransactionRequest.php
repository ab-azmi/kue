<?php

namespace App\Http\Requests\Transaction;

use GlobalXtreme\Validation\Support\FormRequest;

class TransactionRequest extends FormRequest
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
            'quantity' => 'required|numeric',
            'tax' => 'nullable|string',
            'orderPrice' => 'nullable|numeric',
            'totalPrice' => 'nullable|numeric',
            'totalDiscount' => 'nullable|numeric',
            'cashierId' => 'required|exists:users,id',
            'orders' => 'required|array',
            'orders.*.cakeId' => 'required|exists:cakes,id',
            'orders.*.quantity' => 'required|integer',
        ];
    }
}
