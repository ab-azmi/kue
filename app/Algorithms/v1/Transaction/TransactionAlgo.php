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

    public function create(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->transaction = Transaction::create($request->except('orders'));

                $this->transaction->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Transaction : ' . $this->transaction->id);

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
                $this->transaction->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->transaction->update($request->except('orders'));

                $this->transaction->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Transaction : ' . $this->transaction->id);

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
                $this->transaction->setOldActivityPropertyAttributes(ActivityAction::DELETE);
                $this->transaction->delete();
                $this->transaction->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Transaction : ' . $this->transaction->id);
            });

            return success(TransactionParser::first($this->transaction));
        } catch (\Exception $e) {
            exception($e);
        }
    }

    // ------------------------------------ Private Function ------------------------------------

    private function createOrders($orders)
    {
        foreach ($orders as $order) {
            $orderModel = $this->transaction->orders()->create($order);
            $orderModel->setActivityPropertyAttributes(ActivityAction::CREATE)
                ->saveActivity('Create new Order : ' . $orderModel->id . ' in Transaction : ' . $this->transaction->id);
        }

        $this->setTotalPrices($orders);
        $this->syncCakeStock($orders);
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

    private function calculateTotalPrice($orders)
    {
        $totalPrice = 0;

        foreach ($orders as $order) {
            $totalPrice += $order['price'] * $order['quantity'] - $order['discount'];
        }

        return $totalPrice;
    }

    private function calculateSumOrderPrice($orders)
    {
        $sumOrderPrice = 0;

        foreach ($orders as $order) {
            $sumOrderPrice += $order['price'] * $order['quantity'];
        }

        return $sumOrderPrice;
    }

    private function calculateTotalDiscount($orders)
    {
        $totalDiscount = 0;

        foreach ($orders as $order) {
            $totalDiscount += $order['discount'];
        }

        return $totalDiscount;
    }

    private function syncCakeStock($orders)
    {
        foreach ($orders as $order) {
            $cake = Cake::find($order['cakeId']);
            $cake->stock -= $order['quantity'];
            $cake->save();
        }
    }

    private function setTotalPrices($orders)
    {
        $total = $this->calculateTotalPrice($orders);
        $tax = $total * Tax::TAX_10;
        $total += $tax;

        $this->transaction->update([
            'orderPrice' => $this->calculateSumOrderPrice($orders),
            'totalPrice' => $total,
            'totalDiscount' => $this->calculateTotalDiscount($orders),
            'tax' => $tax
        ]);
    }
}
