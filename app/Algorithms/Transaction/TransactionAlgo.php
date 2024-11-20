<?php

namespace App\Algorithms\Transaction;

use App\Models\Cake\Cake;
use App\Models\Setting\Setting;
use App\Models\Transaction\Transaction;
use App\Parser\Transaction\TransactionParser;
use App\Services\Constant\Activity\ActivityAction;
use App\Services\Number\Generator\Transaction\PurchaseNumber;
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

                $request->merge([
                    'code' => PurchaseNumber::generate(),
                ]);

                $this->transaction = Transaction::create($request->only([
                    'quantity',
                    'code',
                    'orderPrice',
                    'totalPrice',
                    'totalDiscount',
                    'tax',
                    'employeeId',
                ]));

                $this->createOrders($orders);
                $this->transaction->refresh();
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
                $this->transaction->update($request->only([
                    'quantity',
                    'orderPrice',
                    'totalPrice',
                    'totalDiscount',
                    'tax',
                    'employeeId',
                ]));

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

    /** --- PRIVATE FUNCTIONS --- */

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
            $cake = Cake::with('variant')->find($order['cakeId']);

            $sellingPrice = $cake->sellingPrice + $cake->variant->price;

            $orders[$key]['price'] = $sellingPrice;
            $orders[$key]['discount'] = $cake->discounts->sum('value');
            $orders[$key]['totalPrice'] = ($sellingPrice * $order['quantity']) - $orders[$key]['discount'];
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
    
            Cake::where('id', $order['cakeId'])->decrement('stock', $order['quantity']);
        }
    }

    private function setTotalPrices($orders) : array
    {
        $tax = Setting::where('key', 'tax')->first()->value;
        $totalPrice = 0;
        $sumOrderPrice = 0;
        $totalDiscount = 0;

        foreach ($orders as $order) {
            $sumOrderPrice += $order['price'] * $order['quantity'];
            $totalDiscount += $order['discount'];
        }

        $totalPrice = $sumOrderPrice - $totalDiscount;
        $tax = $totalPrice * (int)$tax;
        $totalPrice += $tax;

        return [
            'orderPrice' => $sumOrderPrice,
            'totalPrice' => $totalPrice,
            'totalDiscount' => $totalDiscount,
            'tax' => $tax
        ];
    }
}
