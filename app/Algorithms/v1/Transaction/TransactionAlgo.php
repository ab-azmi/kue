<?php

namespace App\Algorithms\v1\Transaction;

use App\Models\v1\Cake\Cake;
use App\Models\v1\Transaction\Order;
use App\Models\v1\Transaction\Transaction;
use App\Parser\Transaction\TransactionParser;
use App\Services\Constant\Activity\ActivityAction;
use App\Services\Constant\Cake\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionAlgo
{
    public function __construct(public ?Transaction $transaction = null) {}

    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $orders = $this->processOrders($request);
                $this->transaction = Transaction::create($request->except('orders'));
                $this->createOrders($orders);
                $this->transaction->refresh();
            });

            return response()->json($this->transaction);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function update(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->transaction->update($request->except('orders'));

                if ($request->has('orders')) {
                    $orders = $this->implementCakesDiscountToOrders($request->orders);
                    $this->updateOrders($orders);
                }
            });

            return success(TransactionParser::first($this->transaction));
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function delete()
    {
        try {
            DB::transaction(function () {
                $this->transaction->delete();
            });

            return success(TransactionParser::first($this->transaction));
        } catch (\Exception $e) {
            exception($e);
        }
    }

    // ------------------------------------ Private Function ------------------------------------

    private function processOrders(Request $request): array
    {
        if ($request->has('orders')) {
            $orders = $this->implementCakesDiscountToOrders($request->orders);
            $this->syncCakeStock($orders);
            extract($this->setTotalPrices($orders));

            $request->merge([
                'orderPrice' => $orderPrice,
                'totalPrice' => $totalPrice,
                'totalDiscount' => $totalDiscount,
                'tax' => $tax
            ]);

            return $orders;
        }

        return [];
    }

    private function createOrders($orders): void
    {
        foreach ($orders as $order) {
            $orderModel = $this->transaction->orders()->create($order);
            $orderModel->setActivityPropertyAttributes(ActivityAction::CREATE)
                ->saveActivity('Create new Order : ' . $orderModel->id . ' in Transaction : ' . $this->transaction->id);
        }
    }

    private function updateOrders($request): void
    {
        $this->transaction->orders()->delete();
        $this->createOrders($request);
    }

    private function implementCakesDiscountToOrders($orders) : array
    {
        foreach ($orders as $key => $order) {
            $cake = Cake::find($order['cakeId']);
            $orders[$key]['price'] = $cake->sellPrice;
            $orders[$key]['discount'] = $cake->discounts->sum('value');
        }

        return $orders;
    }

    private function syncCakeStock($orders) : void
    {
        $cakesIds = array_unique(array_column($orders, 'cakeId'));
        $cakes = Cake::whereIn('id', $cakesIds)->get()->keyBy('id');

        foreach ($orders as $order) {
            $cake = $cakes[$order['cakeId']];

            if ($cake->stock < $order['quantity']) {
                throw new \Exception('Stock is not enough for cake : ' . $cake->name);
            }

            $cake->stock -= $order['quantity'];
            $cake->save();
        }
    }

    private function setTotalPrices($orders) : array
    {
        $totalPrice = 0;
        $sumOrderPrice = 0;
        $totalDiscount = 0;

        foreach ($orders as $order) {
            $sumOrderPrice += $order['price'] * $order['quantity'];
            $totalDiscount += $order['discount'];
        }

        $totalPrice = $sumOrderPrice - $totalDiscount;
        $tax = $totalPrice * Tax::TAX_10;
        $totalPrice += $tax;

        return [
            'orderPrice' => $sumOrderPrice,
            'totalPrice' => $totalPrice,
            'totalDiscount' => $totalDiscount,
            'tax' => $tax
        ];
    }
}
