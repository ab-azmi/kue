<?php

namespace App\Http\Requests\Transaction;

use GlobalXtreme\Validation\Support\FormRequest;
use Illuminate\Contracts\Validation\Validator;

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
            'quantity' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'orderPrice' => 'nullable|numeric',
            'totalPrice' => 'nullable|numeric',
            'totalDiscount' => 'nullable|numeric',
            'employeeId' => 'required|exists:employees,id',
            'orders' => 'required|array',
            'orders.*.cakeId' => 'required|exists:cakes,id',
            'orders.*.quantity' => 'required|integer',
        ];
    }
}
