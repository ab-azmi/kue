<?php

namespace App\Algorithms\Cake;

use App\Models\Cake\Cake;
use App\Models\Cake\CakeComponentIngredient;
use App\Models\Employee\EmployeeSalary;
use App\Models\Setting\Setting;
use App\Models\Setting\SettingFixedCost;
use App\Parser\Cake\CakeParser;
use App\Services\Constant\Activity\ActivityAction;
use App\Services\Constant\Path\Path;
use App\Services\Constant\Setting\SettingConstant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CakeAlgo
{
    /**
     * @param Cake|int|null
     */
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

                $ids = $this->cake->ingredients()->pluck('id')->toArray();
                $this->cake->ingredients()->updateExistingPivot($ids, ['isActive' => false]);

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

            $totalIngredientCost = $this->calculateIngredientsCost($request->ingredients, $request->volume);

            $sums = $this->calculateSums($salarySum, $fixedCostMonthly, $totalIngredientCost);

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCakeImage(Request $request)
    {
        try {
            $path = Path::STORAGE_PUBLIC_PATH('cakes');

            $attachment = [];

            if ($request->hasFile('image')) {
                $file = $request->file('image');

                $fileName = $file->getClientOriginalName();

                $uploaded = $file->storeAs($path, $fileName, 'public');
                if(!$uploaded) {
                    errCakeUploadImage();
                }

                $attachment = [
                    'name' => $fileName,
                    'path' => Path::CAKE_URL_PATH($fileName)
                ];
            }

            return success($attachment);
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

            $oldIngredients = $this->cake->ingredients;

            $this->syncIngredientsRelationship($request->ingredients);
            
            $this->syncIngredientStock($request->ingredients, $oldIngredients);
        } else {
            $this->cake = Cake::create($form);
            if (!$this->cake) {
                errCakeCreate();
            }

            $this->syncIngredientsRelationship($request->ingredients);

            $this->syncIngredientStock($request->ingredients);
        }
    }

    private function syncIngredientsRelationship($ingredients)
    {
        $existingIds = $this->cake->ingredients()->pluck('cake_component_ingredients.id')->toArray();

        $this->cake->ingredients()->updateExistingPivot($existingIds, ['isActive' => false, 'quantity' => 0]);
        
        
        foreach ($ingredients as $ingredient) {
            if (in_array($ingredient['ingredientId'], $existingIds)) 
            {
                $this->cake->ingredients()->updateExistingPivot($ingredient['ingredientId'], [
                    'quantity' => $ingredient['quantity'] * $this->cake->stock,
                    'isActive' => true
                ]);
            } else {
                $this->cake->ingredients()->attach($ingredient['ingredientId'], [
                    'quantity' => $ingredient['quantity'] * $this->cake->stock,
                    'isActive' => true
                ]);
            }
        }
        
    }

    private function syncIngredientStock($ingredients, $oldIngredients = null)
    {
        if ($oldIngredients) {
            $this->incrementIngredientStock($oldIngredients);
        }

        foreach ($ingredients as $ingredient) {
            $ingredientModel = $this->cake->ingredients()->find($ingredient['ingredientId']);
            if (!$ingredientModel) {
                errCakeIngredientGet();
            }

            $ingredientModel->quantity -= ($ingredient['quantity'] * $this->cake->stock);

            $decremented = $ingredientModel->save();
            if (!$decremented) {
                errCakeIngredientDecrementStock();
            }
        }
    }

    private function incrementIngredientStock($oldIngredients)
    {
        foreach ($oldIngredients as $oldIngredient) {
            $usedQuantity = $oldIngredient->used->quantity * $this->cake->stock;

            $oldIngredient->quantity += $usedQuantity;

            $incremented = $oldIngredient->save();

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

    private function calculateSums(int $salarySum, int $fixedCostMonthly, int $totalIngredientCost): int
    {
        return $salarySum + $fixedCostMonthly + $totalIngredientCost;
    }

    private function calculateIngredientsCost($_ingredients, int $volume): int
    {

        $totalIngredientCost = 0;

        $ingredientIds = array_unique(array_column($_ingredients, 'id'));

        $ingredients = CakeComponentIngredient::whereIn('id', $ingredientIds)->get()->keyBy('id');
        if (count($ingredients) !== count($ingredientIds)) {
            errCakeIngredientTotalCost();
        }

        foreach ($_ingredients as $ingredient) {
            $pricePerUnit = $ingredients[$ingredient['id']]->price;

            $quantity = $ingredient['quantity'];

            $totalIngredientCost += ($pricePerUnit * $quantity) * $volume;
        }

        if ($totalIngredientCost <= 0) {
            errCakeIngredientTotalCost();
        }

        return $totalIngredientCost;
    }
}
