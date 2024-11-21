<?php

namespace App\Algorithms\Transaction;

use App\Models\Cake\Cake;
use App\Models\Setting\Setting;
use App\Models\Transaction\Transaction;
use App\Parser\Transaction\TransactionParser;
use App\Services\Constant\Activity\ActivityAction;
use App\Services\Constant\Setting\SettingConstant;
use App\Services\Number\Generator\TransactionNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionAlgo
{
    public function __construct(public Transaction|int|null $transaction = null)
    {
        if (is_int($transaction)) {
            $this->transaction = Transaction::find($transaction);
            if (!$this->transaction) {
                errTransactionGet();
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $orders = $this->processOrders($request);

                $request->merge([
                    'number' => TransactionNumber::generate(),
                ]);
                
                $this->saveTransaction($request);

                $this->createOrders($orders);
            });

            return success(TransactionParser::first($this->transaction));
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->saveTransaction($request);

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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete()
    {
        try {
            DB::transaction(function () {
                $deleted = $this->transaction->delete();
                if (!$deleted) {
                    errTransactionDelete();
                }
            });

            return success(TransactionParser::first($this->transaction));
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /** --- PRIVATE FUNCTIONS --- */

    private function saveTransaction($request)
    {
        $form = $request->only([
            'quantity',
            'orderPrice',
            'totalPrice',
            'totalDiscount',
            'tax',
            'employeeId',
            'number'
        ]);

        if($this->transaction) {
            $updated = $this->transaction->update($form);
            if(!$updated) {
                errTransactionUpdate();
            }
        } else {
            $this->transaction = Transaction::create($form);
            if(!$this->transaction) {
                errTransactionCreate();
            }
        }
    }

    private function processOrders(Request $request): array
    {
        if ($request->has('orders')) {
            $orders = $this->implementCakesDiscountToOrders($request->orders);

            $this->syncCakeStock($orders);

            extract($this->setTotalPrices($orders));
            if(!$totalPrice) {
                errTransactionTotalPrice();
            }
            if(!$totalDiscount){
                errTransactionTotalDiscount();
            }
            if(!$tax) {
                errTransactionTax();
            }

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

    private function createOrders($orders)
    {
        foreach ($orders as $order) {
            $orderModel = $this->transaction->orders()->create($order);

            if (!$orderModel) {
                errCreateOrder();
            }

            $orderModel->setActivityPropertyAttributes(ActivityAction::CREATE)
                ->saveActivity('Create new Order : ' . $orderModel->id . ' in Transaction : ' . $this->transaction->id);
        }
    }

    private function updateOrders($request): void
    {
        $this->transaction->orders()->delete();
        $this->createOrders($request);
    }

    private function implementCakesDiscountToOrders($orders): array
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

    private function syncCakeStock($orders)
    {
        $cakesIds = array_unique(array_column($orders, 'cakeId'));
        $cakes = Cake::whereIn('id', $cakesIds)->get()->keyBy('id');

        foreach ($orders as $order) {
            $cake = $cakes[$order['cakeId']];

            if ($cake->stock < $order['quantity']) {
                errOutOfStockOrder($cake->name);
            }

            Cake::where('id', $order['cakeId'])->decrement('stock', $order['quantity']);
        }
    }

    private function setTotalPrices($orders): array
    {
        $tax = Setting::where('key', SettingConstant::TAX_KEY)->first()->value;
        $totalPrice = 0;
        $sumOrderPrice = 0;
        $totalDiscount = 0;
  
        foreach ($orders as $order) {
            $sumOrderPrice += $order['price'] * $order['quantity'];
            $totalDiscount += $order['discount'];
        }

        $totalPrice = $sumOrderPrice - $totalDiscount;
        $tax = $totalPrice * (float)$tax;
        $totalPrice += (float)$tax;
        
        return [
            'orderPrice' => $sumOrderPrice,
            'totalPrice' => $totalPrice,
            'totalDiscount' => $totalDiscount,
            'tax' => $tax
        ];
    }
}
