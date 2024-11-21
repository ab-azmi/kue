<?php

namespace App\Http\Controllers\Web\Transaction;

use App\Algorithms\Transaction\TransactionAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\TransactionRequest;
use App\Models\Transaction\Transaction;
use App\Parser\Transaction\TransactionParser;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $transactions = Transaction::with([
            'orders',
            'employee'
        ])->orderBy('createdAt')->getOrPaginate($request, true);

        return success(TransactionParser::briefs($transactions));
    }

    /**
     * @param App\Http\Requests\Transaction\TransactionRequest;
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(TransactionRequest $request)
    {
        $algo = new TransactionAlgo();
        return $algo->store($request);
    }

    /**
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $transaction = Transaction::with([
            'orders',
            'orders.cake',
            'employee'
        ])->find($id);
        if (!$transaction) {
            errGetTransaction();
        }

        return success(TransactionParser::first($transaction));
    }

    /**
     * @param string|int $id
     * @param App\Http\Requests\Transaction\TransactionRequest;
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, TransactionRequest $request)
    {
        $algo = new TransactionAlgo((int)$id);
        return $algo->update($request);
    }

    /**
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $algo = new TransactionAlgo((int)$id);
        return $algo->delete();
    }
}
