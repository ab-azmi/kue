<?php

namespace App\Algorithms\Transaction;

use App\Models\Cake\CakeVariant;
use App\Models\Setting\Setting;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionOrder;
use App\Parser\Transaction\TransactionParser;
use App\Services\Constant\Activity\ActivityAction;
use App\Services\Constant\Setting\SettingConstant;
use App\Services\Number\Generator\TransactionNumber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionAlgo
{
    /**
     * @param Transaction|int|null $transaction
     * @param array $cakeVariants
     */
    public function __construct(public Transaction|int|null $transaction = null, private $cakeVariants = [])
    {
        if (is_int($transaction)) {
            $this->transaction = Transaction::find($transaction);
            if (! $this->transaction) {
                errTransactionGet();
            }
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|mixed
     */
    public function create(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->saveTransaction($request);

                $this->createOrders($request);

                $this->transaction->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Transaction : '.$this->transaction->id);
            });

            return success($this->transaction);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /**
     * @return JsonResponse|mixed
     */
    public function delete()
    {
        try {
            $this->transaction->setOldActivityPropertyAttributes(ActivityAction::DELETE);

            $this->transaction->delete();

            $this->transaction->setActivityPropertyAttributes(ActivityAction::DELETE)
                ->saveActivity('Delete Transaction : '.$this->transaction->id);

            return success();
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
        ]);

        $form['number'] = TransactionNumber::generate();

        $this->transaction = Transaction::create($form);
        if (! $this->transaction) {
            errTransactionCreate();
        }

    }

    private function createOrders($request)
    {
        foreach ($request->orders as $order) {
            $orderModel = TransactionOrder::create($order + ['transactionId' => $this->transaction->id]);
            if (! $orderModel) {
                errCreateOrder();
            }
        }

        $this->calculateOrders();
    }

    private function calculateOrders()
    {
        $this->implementCakesDiscountToOrders();

        $this->syncCakeStock();

        $result = $this->setTotalPrices();

        $this->transaction->update([
            'orderPrice' => $result['orderPrice'],
            'totalPrice' => $result['totalPrice'],
            'totalDiscount' => $result['totalDiscount'],
            'tax' => $result['tax'],
        ]);
    }

    private function implementCakesDiscountToOrders()
    {
        foreach ($this->transaction->orders as $order) {
            $cakeVariant = CakeVariant::with('cake')->find($order['cakeVariantId']);
            if (!$cakeVariant) {
                errCakeGet();
            }

            $this->cakeVariants[$cakeVariant->id] = $cakeVariant;

            $sellingPrice = $this->calculateCakeVariantsPrice($cakeVariant);

            $totalDiscount = $cakeVariant->cake?->discounts->sum('value') * $order['quantity'];

            $order->update([
                'price' => $sellingPrice,
                'discount' => $totalDiscount,
                'totalPrice' => ($sellingPrice * $order['quantity']) - $totalDiscount,
            ]);
        }
    }

    private function calculateCakeVariantsPrice($cakeVariant): float
    {
        $sellingPrice = $cakeVariant->cake?->sellingPrice;

        if ($cakeVariant->price) {
            $sellingPrice += $cakeVariant->price;
        }

        return $sellingPrice;
    }

    private function syncCakeStock()
    {
        foreach ($this->transaction->orders as $order) {
            $cake = $this->cakeVariants[$order['cakeVariantId']]->cake;
            if ($cake->stock < $order['quantity']) {
                errOutOfStockOrder($cake->name);
            }

            $cake->decrement('stock', $order['quantity']);
        }
    }

    private function setTotalPrices(): array
    {
        $tax = Setting::where('key', SettingConstant::TAX_KEY)->first()->value;
        $sumOrderPrice = 0;
        $totalDiscount = 0;

        foreach ($this->transaction->orders as $order) {
            $sumOrderPrice += $order['totalPrice'];
            $totalDiscount += $order['discount'];
        }

        $totalPrice = $sumOrderPrice - $totalDiscount;
        $tax = $totalPrice * (float) $tax;
        $totalPrice += $tax;

        return [
            'orderPrice' => $sumOrderPrice,
            'totalPrice' => $totalPrice,
            'totalDiscount' => $totalDiscount,
            'tax' => $tax,
        ];
    }
}
