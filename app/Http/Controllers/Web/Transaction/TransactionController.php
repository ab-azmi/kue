<?php

namespace App\Http\Controllers\Web\Transaction;

use App\Algorithms\Transaction\TransactionAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\TransactionRequest;
use App\Models\Transaction\Transaction;
use App\Parser\Transaction\TransactionParser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse|mixed
     */
    public function get(Request $request)
    {
        $transactions = Transaction::filter($request)->with([
            'orders',
            'employee',
        ])->getOrPaginate($request, true);

        return success(TransactionParser::briefs($transactions), pagination: pagination($transactions));
    }

    /**
     * @param string $id
     *
     * @return JsonResponse|mixed
     */
    public function detail($id)
    {
        $transaction = Transaction::with([
            'orders',
            'orders.cakeVariant',
            'employee',
        ])->find($id);
        if (! $transaction) {
            errTransactionGet();
        }

        return success($transaction);
    }

    /**
     * @param TransactionRequest $request
     *
     * @return JsonResponse|mixed
     */
    public function create(TransactionRequest $request)
    {
        $algo = new TransactionAlgo;
        return $algo->create($request);
    }


    /**
     * @param  string  $id
     *
     * @return JsonResponse|mixed
     */
    public function delete($id)
    {
        $algo = new TransactionAlgo((int) $id);
        return $algo->delete();
    }

    public function monthlySummary()
    {
        $algo = new TransactionAlgo;
        return $algo->monthlySummary();
    }
}
