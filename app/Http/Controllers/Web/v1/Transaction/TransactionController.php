<?php

namespace App\Http\Controllers\Web\v1\Transaction;

use App\Algorithms\v1\Transaction\TransactionAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Transaction\CreateTransactionRequest;
use App\Http\Requests\v1\Transaction\UpdateTransactionRequest;
use App\Models\v1\Transaction\Transaction;
use App\Parser\Transaction\TransactionParser;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(public $algo = new TransactionAlgo())
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactions = Transaction::with([
            'orders'
        ])->orderBy('createdAt')->getOrPaginate($request, true);
        
        return success(TransactionParser::get($transactions));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTransactionRequest $request)
    {
        return $this->algo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::with([
            'orders',
            'orders.cake',
            'cashier'
        ])->findOrFail($id);
        
        return success(TransactionParser::first($transaction));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, string $id)
    {
        $this->algo->transaction = Transaction::findOrFail($id);
        return $this->algo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->algo->transaction = Transaction::findOrFail($id);
        return $this->algo->delete();
    }
}
