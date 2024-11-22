<?php

namespace App\Algorithms\Cake;

use App\Models\Cake\Cake;
use App\Models\Cake\CakeComponentIngridient;
use App\Models\Employee\EmployeeSalary;
use App\Models\Setting\Setting;
use App\Models\Setting\SettingFixedCost;
use App\Parser\Cake\CakeParser;
use App\Services\Constant\Activity\ActivityAction;
use App\Services\Constant\Setting\SettingConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CakeAlgo
{
    public function __construct(public Cake|int|null $cake = null)
    {
        if (is_int($cake)) {
            $this->cake = Cake::find($cake);
            if (!$this->cake) {
                errCakeGet();
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->saveCake($request);

                $this->cake->load('variant');

                $this->cake->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Cake : ' . $this->cake->id);
            });

            return success(CakeParser::first($this->cake));
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
                $this->cake->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->saveCake($request);

                $this->cake->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Cake : ' . $this->cake->id);
            });

            return success(CakeParser::first($this->cake));
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
                $this->cake->setOldActivityPropertyAttributes(ActivityAction::DELETE);

                $ids = $this->cake->ingridients()->pluck('id')->toArray();
                $this->cake->ingridients()->updateExistingPivot($ids, ['isActive' => false]);

                $deleted = $this->cake->delete();
                if (!$deleted) {
                    errCakeDelete();
                }

                $this->cake->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Cake : ' . $this->cake->id);
            });

            return success(CakeParser::first($this->cake));
        } catch (\Exception $e) {
            return exception($e);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function COGS(Request $request)
    {
        try {
            $margin = $this->getMargin($request);

            $salarySum = $this->getSalarySum();

            $fixedCostMonthly = $this->getFixedCostMonthly();

            $totalIngridientCost = $this->calculateIngridientsCost($request->ingridients, $request->volume);

            $sums = $this->calculateSums($salarySum, $fixedCostMonthly, $totalIngridientCost);

            $sellingPrice = $this->calculateSellingPrice($sums, $margin) / $request->volume;

            $cogs = $sums / $request->volume;
            if ($cogs <= 0) {
                errCakeCOGS();
            }

            return success([
                'COGS' => $cogs,
                'sellingPrice' => $sellingPrice,
                'profitPerItem' => $sellingPrice - $cogs
            ]);
        } catch (\Exception $e) {
            return exception($e);
        }
    }

    /** --- PRIVATE FUNCTIONS --- */

    private function saveCake(Request $request)
    {
        $form = $request->safe()->only([
            'name',
            'stock',
            'cakeVariantId',
            'profitMargin',
            'COGS',
            'sellingPrice',
            'images',
        ]);

        if ($this->cake) {
            $updated = $this->cake->update($form);
            if (!$updated) {
                errCakeUpdate();
            }

            $oldIngridients = $this->cake->ingridients;

            $this->syncIngridientsRelationship($request->ingridients);
            
            $this->syncIngridientStock($request->ingridients, $oldIngridients);
        } else {
            $this->cake = Cake::create($form);
            if (!$this->cake) {
                errCakeCreate();
            }

            $this->syncIngridientsRelationship($request->ingridients);

            $this->syncIngridientStock($request->ingridients);
        }
    }

    private function syncIngridientsRelationship($ingridients)
    {
        $existingIds = $this->cake->ingridients()->pluck('cake_component_ingridients.id')->toArray();

        $this->cake->ingridients()->updateExistingPivot($existingIds, ['isActive' => false, 'quantity' => 0]);
        
        
        foreach ($ingridients as $ingridient) {
            if (in_array($ingridient['ingridientId'], $existingIds)) 
            {
                $this->cake->ingridients()->updateExistingPivot($ingridient['ingridientId'], [
                    'quantity' => $ingridient['quantity'] * $this->cake->stock,
                    'isActive' => true
                ]);
            } else {
                $this->cake->ingridients()->attach($ingridient['ingridientId'], [
                    'quantity' => $ingridient['quantity'] * $this->cake->stock,
                    'isActive' => true
                ]);
            }
        }
        
    }

    private function syncIngridientStock($ingridients, $oldIngridients = null)
    {
        if ($oldIngridients) {
            $this->incrementIngredientStock($oldIngridients);
        }

        foreach ($ingridients as $ingridient) {
            $ingridientModel = $this->cake->ingridients()->find($ingridient['ingridientId']);
            if (!$ingridientModel) {
                errCakeIngredientGet();
            }

            $ingridientModel->quantity -= ($ingridient['quantity'] * $this->cake->stock);

            $decremented = $ingridientModel->save();
            if (!$decremented) {
                errCakeIngredientDecrementStock();
            }
        }
    }

    private function incrementIngredientStock($oldIngridients)
    {
        foreach ($oldIngridients as $oldIngridient) {
            $usedQuantity = $oldIngridient->used->quantity * $this->cake->stock;

            $oldIngridient->quantity += $usedQuantity;

            $incremented = $oldIngridient->save();

            if (!$incremented) {
                errCakeIngredientDecrementStock();
            }
        }
    }

    private function calculateSellingPrice(int $cogs, float $margin)
    {
        return $cogs * (1 + $margin);
    }

    private function getMargin(Request $request): float
    {
        $default = Setting::where('key', SettingConstant::PROFIT_MARGIN_KEY)->first()->value;

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

        $totalIngridientCost = 0;

        $ingridientIds = array_unique(array_column($_ingridients, 'id'));

        $ingridients = CakeComponentIngridient::whereIn('id', $ingridientIds)->get()->keyBy('id');
        if (count($ingridients) !== count($ingridientIds)) {
            errCakeIngredientTotalCost();
        }

        foreach ($_ingridients as $ingridient) {
            $pricePerUnit = $ingridients[$ingridient['id']]->price;

            $quantity = $ingridient['quantity'];

            $totalIngridientCost += ($pricePerUnit * $quantity) * $volume;
        }

        if ($totalIngridientCost <= 0) {
            errCakeIngredientTotalCost();
        }

        return $totalIngridientCost;
    }
}
