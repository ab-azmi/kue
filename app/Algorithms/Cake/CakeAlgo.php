<?php

namespace App\Algorithms\Cake;

use App\Models\Cake\Cake;
use App\Models\Cake\CakeComponentIngridient;
use App\Models\Employee\EmployeeSalary;
use App\Models\Setting\SettingFixedCost;
use App\Parser\Cake\CakeParser;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CakeAlgo
{
    public function __construct(public ?Cake $cake = null) {}

    public function create(Request $request)
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

                $this->cake->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Cake : ' . $this->cake->id);
            });

            return success(CakeParser::first($this->cake));
        } catch (\Exception $e) {
            return errCreateCake($e->getMessage());
        }
    }

    public function update(Request $request)
    {

        try {
            DB::transaction(function () use ($request) {
                $this->cake->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

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

                $this->cake->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Cake : ' . $this->cake->id);
            });

            return success(CakeParser::first($this->cake));
        } catch (\Exception $e) {
            return errUpdateCake($e->getMessage());
        }
    }

    public function delete()
    {
        try {
            DB::transaction(function () {
                $this->cake->setOldActivityPropertyAttributes(ActivityAction::DELETE);

                $this->cake->ingridients()->detach();
                $this->cake->delete();

                $this->cake->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Cake : ' . $this->cake->id);
            });

            return success(CakeParser::first($this->cake));
        } catch (\Exception $e) {
            return errDeleteCake($e->getMessage());
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
            return errCalculatingCOGS($e->getMessage());
        }
    }

    /** --- PRIVATE FUNCTIONS --- */

    private function decrementIngridient($ingridients)
    {
        try {
            foreach ($ingridients as $ingridient) {
                CakeComponentIngridient::find($ingridient['ingridientId'])
                    ->decrement('quantity', ($ingridient['quantity'] * $this->cake->volume));
            }
        } catch (\Exception $e) {
            return errDecrementingIngridientStock($e->getMessage());
        }
    }

    private function attachIngridients($ingridients)
    {
        try {
            $this->cake->ingridients()->attach($ingridients);

            $this->decrementIngridient($ingridients);
        } catch (\Exception $e) {
            errAttachIngridients($e->getMessage());
        }
    }

    private function detachIngridients()
    {
        try {
            $this->cake->ingridients()->each(function ($ingridient) {
                $ingridient->increment('quantity', ($ingridient->used->quantity * $this->cake->stock));
            });

            $this->cake->ingridients()->detach();
        } catch (\Exception $e) {
            return errDetachingIngridients($e->getMessage());
        }
    }

    private function calculateSellingPrice(int $cogs, float $margin)
    {
        return $cogs * (1 + $margin);
    }

    private function getMargin(Request $request): float
    {
        $default = 0.3;

        if ($request->has('margin') && $request->margin) {
            $default = (float) $request->margin;
        }

        return $default;
    }

    private function getSalarySum(): int
    {
        return EmployeeSalary::sum('totalSalary');
    }

    private function getFixedCostMonthly(): int
    {
        return SettingFixedCost::where('frequency', 'monthly')->sum('amount');
    }

    private function calculateSums(int $salarySum, int $fixedCostMonthly, int $totalIngridientCost): int
    {
        return $salarySum + $fixedCostMonthly + $totalIngridientCost;
    }

    private function calculateIngridientsCost($_ingridients, int $volume): int
    {
        try {
            $totalIngridientCost = 0;
            $ingridientIds = array_unique(array_column($_ingridients, 'id'));
            $ingridients = CakeComponentIngridient::whereIn('id', $ingridientIds)->get()->keyBy('id');

            foreach ($_ingridients as $ingridient) {
                $pricePerUnit = $ingridients[$ingridient['id']]->price;
                $quantity = $ingridient['quantity'];
                $totalIngridientCost += ($pricePerUnit * $quantity) * $volume;
            }

            return $totalIngridientCost;
        } catch (\Exception $e) {
            errCalculatingIngridientCost($e->getMessage());
        }
    }
}
