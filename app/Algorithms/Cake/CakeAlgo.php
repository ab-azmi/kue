<?php

namespace App\Algorithms\Cake;

use App\Models\Cake\Cake;
use App\Models\Cake\CakeComponentIngridient;
use App\Models\Employee\EmployeeSalary;
use App\Models\Setting\SettingFixedCost;
use App\Parser\Cake\CakeParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CakeAlgo
{
    public function __construct(public ?Cake $cake = null) {}

    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $data = $request->only([
                    'name',
                    'cakeVariantId',
                    'profitMargin',
                    'COGS',
                    'sellingPrice',
                    'images',
                ]);
                $this->cake = Cake::create($data);
                $this->attachIngridients($request->ingridients);

                $this->cake->load([
                    'variant',
                    'ingridients',
                ]);
            });

            return success(CakeParser::first($this->cake));
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function update(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->detachIngridients();
                $this->cake->update($request->only([
                    'name',
                    'cakeVariantId',
                    'profitMargin',
                    'COGS',
                    'sellingPrice',
                    'images',
                ]));
                $this->attachIngridients($request->ingridients);
            });

            return success(CakeParser::first($this->cake));
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function destroy()
    {
        try {
            DB::transaction(function () {
                $this->cake->ingridients()->detach();
                $this->cake->delete();
            });

            return success(CakeParser::first($this->cake));
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function COGS(Request $request)
    {
        try {
            // Assunming the unit are the same as in ingridient table
            $margin = $this->getMargin($request);
            $salarySum = $this->getSalarySum();
            $fixedCostMonthly = $this->getFixedCostMonthly();
            $totalIngridientCost = $this->calculateIngridientsCost($request->ingridients, $request->volume);

            $sums = $this->calculateSums($salarySum, $fixedCostMonthly, $totalIngridientCost);
            $sellingPrice = $this->calculateSellingPrice($sums, $margin) / $request->volume;
            $cogs = $sums / $request->volume;

            return success([
                'COGS' => $cogs,
                'sellingPrice' => $sellingPrice,
                'profitPerItem' => $sellingPrice - $cogs
            ]);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /** --- PRIVATE FUNCTIONS --- */

    private function attachIngridients($ingridients)
    {
        $this->cake->ingridients()->attach($ingridients);

        foreach ($ingridients as $ingridient) {
            CakeComponentIngridient::find($ingridient['ingridientId'])->decrement('quantity', $ingridient['quantity']);
        }
    }

    private function detachIngridients()
    {
        $this->cake->ingridients()->each(function ($ingridient) {
            $ingridient->increment('quantity', $ingridient->used->quantity);
        });
        $this->cake->ingridients()->detach();
    }

    private function calculateSellingPrice(int $cogs, float $margin)
    {
        return $cogs * (1 + $margin);
    }

    private function getMargin(Request $request) : float
    {
        $default = 0.3;

        if ($request->has('margin') && $request->margin) {
            $default = (float) $request->margin;
        }

        return $default;
    }

    private function getSalarySum() : int
    {
        return EmployeeSalary::sum('totalSalary');
    }

    private function getFixedCostMonthly() : int
    {
        return SettingFixedCost::where('frequency', 'monthly')->sum('amount');
    }

    private function calculateSums(int $salarySum, int $fixedCostMonthly, int $totalIngridientCost) : int
    {
        return $salarySum + $fixedCostMonthly + $totalIngridientCost;
    }

    private function calculateIngridientsCost($_ingridients, int $volume) : int
    {
        $totalIngridientCost = 0;
        $ingridientIds = array_unique(array_column($_ingridients, 'id'));
        $ingridients = CakeComponentIngridient::whereIn('id', $ingridientIds)->get()->keyBy('id');

        foreach ($_ingridients as $ingridient) {
            $pricePerUnit = $ingridients[$ingridient['id']]->pricePerUnit;
            $quantity = $ingridient['quantity'];
            $totalIngridientCost += ($pricePerUnit * $quantity) * $volume;
        }

        return $totalIngridientCost;
    }
}
