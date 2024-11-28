<?php

namespace App\Algorithms\Cake;

use App\Models\Cake\Cake;
use App\Models\Cake\CakeComponentIngredient;
use App\Models\Cake\CakeIngredient;
use App\Models\Employee\EmployeeSalary;
use App\Models\Setting\Setting;
use App\Models\Setting\SettingFixedCost;
use App\Parser\Cake\CakeParser;
use App\Services\Constant\Activity\ActivityAction;
use App\Services\Constant\Path\Path;
use App\Services\Constant\Setting\SettingConstant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CakeAlgo
{
    private array $deletedImages = [];

    /**
     * @param Cake|int|null $cake
     */
    public function __construct(public Cake|int|null $cake = null)
    {
        if (is_int($cake)) {
            $this->cake = Cake::find($cake);
            if (! $this->cake) {
                errCakeGet();
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
                $this->saveCake($request);

                $this->saveCakeImages($request);

                $this->syncIngredientsRelationship($request);

                $this->syncIngredientStock($request);

                $this->cake->load('variants');

                $this->cake->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Cake : '.$this->cake->id);
            });

            return success($this->cake);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|mixed
     */
    public function update(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->cake->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->saveCake($request);

                $this->saveCakeImages($request);

                $oldIngredients = $this->cake->ingredients;

                $this->syncIngredientsRelationship($request);

                $this->syncIngredientStock($request, $oldIngredients);

                $this->cake->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Cake : '.$this->cake->id);
            });

            return success($this->cake);
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
            DB::transaction(function () {
                $this->cake->setOldActivityPropertyAttributes(ActivityAction::DELETE);

                $this->cake->cakeIngredients()->delete();

                $deleted = $this->cake->delete();
                if (! $deleted) {
                    errCakeDelete();
                }

                $this->cake->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Cake : '.$this->cake->id);
            });

            return success();
        } catch (\Exception $e) {
            return exception($e);
        }
    }

    /**
     * @return JsonResponse|mixed|void
     */
    public function COGS(Request $request)
    {
        try {
            $margin = $this->getMarginDecimal($request);

            $salarySum = EmployeeSalary::getTotalSalary();

            $fixedCostMonthly = SettingFixedCost::getFixedCostMonthly();

            $totalIngredientCost = $this->calculateIngredientsCost($request);

            $sums = $this->calculateSums($salarySum, $fixedCostMonthly, $totalIngredientCost);

            $sellingPrice = $this->calculateSellingPrice($sums, $margin) / $request->volume;

            $cogs = $sums / $request->volume;
            if ($cogs <= 0) {
                errCakeCOGS();
            }

            return success([
                'COGS' => $cogs,
                'sellingPrice' => $sellingPrice,
                'profitPerItem' => $sellingPrice - $cogs,
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
        ]);

        if ($this->cake) {
            $updated = $this->cake->update($form);
            if (! $updated) {
                errCakeUpdate();
            }

            return;
        }

        $this->cake = Cake::create($form);
        if (! $this->cake) {
            errCakeCreate();
        }
    }

    private function saveCakeImages(Request $request)
    {
        if ($request->has('images')) {
            $path = Path::CAKES;

            foreach ($request->file('images') as $obj) {
                if ($obj['file']) {
                    $fileName = $this->getFileName($obj['file']->getClientOriginalName());

                    $uploaded = $obj['file']->move(Path::STORAGE_PUBLIC_PATH($path), $fileName);
                    if (! $uploaded) {
                        errCakeUploadImage();
                    }

                    $images[] = [
                        'path' => $path.DIRECTORY_SEPARATOR.$fileName,
                        'mime' => $obj['file']->getClientMimeType(),
                        'file' => null,
                        'link' => storage_link($path.DIRECTORY_SEPARATOR.$fileName),
                    ];
                }

                $this->cake->images = $images;
                $this->cake->save();
            }
        }
    }

    private function syncIngredientsRelationship($request)
    {
        $toKeepIds = [];
        foreach($request->ingredients ?: [] as $ingredient) {
            $this->cake->cakeIngredients()->updateOrCreate([
                'ingredientId' => $ingredient['ingredientId'],
                'cakeId' => $this->cake->id,
            ], [
                'quantity' => $ingredient['quantity'],
            ]);

            $toKeepIds[] = $ingredient['ingredientId'];
        }

        CakeIngredient::where('cakeId', $this->cake->id)
            ->whereNotIn('ingredientId', $toKeepIds)
            ->delete();

        $this->cake->componentIngredients()->sync($toKeepIds);
    }

    private function syncIngredientStock($request, $oldIngredients = null)
    {

    }

    private function calculateSellingPrice(float $cogs, float $margin)
    {
        return $cogs * (1 + $margin);
    }

    private function getMarginDecimal(Request $request): float
    {
        $default = Setting::where('key', SettingConstant::PROFIT_MARGIN_KEY)->first()->value;

        if ($request->has('margin') && $request->margin) {
            $default = (float) $request->margin;
        }

        return $default;
    }

    private function calculateSums(float $salarySum, float $fixedCostMonthly, float $totalIngredientCost): float
    {
        return $salarySum + $fixedCostMonthly + $totalIngredientCost;
    }

    private function calculateIngredientsCost($request): float
    {
        $totalIngredientCost = 0;

        $ingredientIds = array_column($request->ingredients, 'id');

        $ingredients = CakeComponentIngredient::whereIn('id', $ingredientIds)->get()->keyBy('id');
        if (count($ingredients) !== count($ingredientIds)) {
            errCakeIngredientTotalCost();
        }

        foreach ($request->ingredients as $ingredient) {
            $pricePerUnit = $ingredients[$ingredient['id']]->price;

            $quantity = $ingredient['quantity'];

            $totalIngredientCost += ($pricePerUnit * $quantity) * $request->volume;
        }

        if ($totalIngredientCost <= 0) {
            errCakeIngredientTotalCost();
        }

        return $totalIngredientCost;
    }

    private function getFileName($originalName): string
    {
        $rand = rand(1000, 9999);

        $time = time();

        $fileName = str_replace(' ', '_', $originalName);

        return $time.$rand.'_'.$fileName;
    }
}
