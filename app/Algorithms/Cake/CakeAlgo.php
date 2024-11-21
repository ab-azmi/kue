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
                errGetCake();
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

                $this->cake->ingridients()->detach();

                $deleted = $this->cake->delete();
                if (!$deleted) {
                    errDeleteCake();
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
                errCalculatingCOGS();
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
                errUpdateCake();
            }

            $this->syncIngridientStock($request->ingridients, $this->cake->ingridients);
            $this->syncIngridients($request->ingridients);
        } else {
            $this->cake = Cake::create($form);
            if (!$this->cake) {
                errCreateCake();
            }

            $this->syncIngridients($request->ingridients);
            $this->syncIngridientStock($request->ingridients);
        }
    }

    private function syncIngridientStock($ingridients, $oldIngridients = null)
    {
        if ($oldIngridients) {
            foreach ($oldIngridients as $oldIngridient) {
                $usedQuantity = $oldIngridient->used->quantity * $this->cake->stock;

                $oldIngridient->quantity += $usedQuantity;

                $incremented = $oldIngridient->save();
                if (!$incremented) {
                    errDecrementingIngridientStock();
                }
            }
        }

        foreach ($ingridients as $ingridient) {
            $ingridientModel = $this->cake->ingridients()->find($ingridient['ingridientId']);
            if (!$ingridientModel) {
                errIngredientNotFound();
            }

            $ingridientModel->quantity -= ($ingridient['quantity'] * $this->cake->stock);

            $decremented = $ingridientModel->save();
            if (!$decremented) {
                errDecrementingIngridientStock();
            }
        }
    }

    private function syncIngridients($ingridients)
    {
        $sync = $this->cake->ingridients()->sync(
            collect($ingridients)->mapWithKeys(function ($ingridient) {
                return [
                    $ingridient['ingridientId'] => [
                        'quantity' => $ingridient['quantity']
                    ]
                ];
            })
        );

        if (!$sync) {
            errSyncIngridients();
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
            errCalculatingIngridientCost();
        }

        foreach ($_ingridients as $ingridient) {
            $pricePerUnit = $ingridients[$ingridient['id']]->price;

            $quantity = $ingridient['quantity'];

            $totalIngridientCost += ($pricePerUnit * $quantity) * $volume;
        }

        if ($totalIngridientCost <= 0) {
            errCalculatingIngridientCost();
        }

        return $totalIngridientCost;
    }
}
