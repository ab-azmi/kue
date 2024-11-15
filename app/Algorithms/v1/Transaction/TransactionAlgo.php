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
                $this->transaction = Transaction::create($request->except('orders'));

                if ($request->has('orders')) {
                    $orders = $this->implementCakesDiscountToOrders($request->orders);
                    $this->createOrders($orders);
                }
                
            });
            
            return success(TransactionParser::first($this->transaction));
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

    private function createOrders($orders)
    {
        $this->syncCakeStock($orders);

        foreach ($orders as $order) {
            $orderModel = $this->transaction->orders()->create($order);
            $orderModel->setActivityPropertyAttributes(ActivityAction::CREATE)
                ->saveActivity('Create new Order : ' . $orderModel->id . ' in Transaction : ' . $this->transaction->id);
        }

        $this->setTotalPrices($orders);
        $this->transaction->refresh();
    }

    private function updateOrders($request)
    {
        $this->transaction->orders()->delete();
        $this->createOrders($request);
    }

    private function implementCakesDiscountToOrders($orders)
    {
        foreach ($orders as $key => $order) {
            $cake = Cake::find($order['cakeId']);
            $orders[$key]['price'] = $cake->sellPrice;
            $orders[$key]['discount'] = $cake->discounts->sum('value');
        }

        return $orders;
    }

    private function syncCakeStock($orders)
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

    private function setTotalPrices($orders)
    {
        $totalPrice = 0;
        $sumOrderPrice = 0;
        $totalDiscount = 0;

        foreach ($orders as $order){
            $sumOrderPrice += $order['price'] * $order['quantity'];
            $totalDiscount += $order['discount'];
        }

        $totalPrice = $sumOrderPrice - $totalDiscount;
        $tax = $totalPrice * Tax::TAX_10;
        $totalPrice += $tax;

        $this->transaction->update([
            'orderPrice' => $sumOrderPrice,
            'totalPrice' => $totalPrice,
            'totalDiscount' => $totalDiscount,
            'tax' => $tax
        ]);
    }
}
