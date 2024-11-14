<?php
namespace App\Algorithms\v1\Transaction;

use App\Models\v1\Transaction\Transaction;
use App\Parser\Transaction\TransactionParser;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionAlgo
{
    public function __construct(public ?Transaction $transaction = null)
    {
        
    }

    public function create(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->transaction = Transaction::create($request->except('orders'));
                $this->transaction->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Transaction : ' . $this->transaction->id);
                
                if($request->has('orders')) {
                    $this->createOrders($request);
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

                if($request->has('orders')) {
                    $this->updateOrders($request);
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

    private function createOrders($request)
    {
        $request->orders->each(function ($order) {
            $orderModel = $this->transaction->orders()->create($order->except('cake'));
            $orderModel->setActivityPropertyAttributes(ActivityAction::CREATE)
                ->saveActivity('Create new Order : ' . $orderModel->id . ' in Transaction : ' . $this->transaction->id);
        });
    }

    private function updateOrders($request)
    {
        $this->transaction->orders()->delete();
        $this->createOrders($request);
    }
    
}