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
use GlobalXtreme\Validation\Validator;
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

                $this->syncVariantsRelationship($request);

                $this->syncIngredientsRelationship($request);

                $this->saveCakeImages($request);

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

                $this->syncVariantsRelationship($request);

                $this->syncIngredientsRelationship($request);

                $this->saveCakeImages($request);

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

                $this->deletedImages = $this->cake->images ?: [];

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

            $percentageForSalary = Setting::where('key', SettingConstant::SALARY_TO_CAKE_PERCENTAGE_KEY)
                    ->first()->value / 100;
            $salaryPercentage = EmployeeSalary::getTotalSalary() * $percentageForSalary;

            $percentageForOverhead = Setting::where('key', SettingConstant::FIXED_COST_TO_CAKE_PERCENTAGE_KEY)
                    ->first()->value / 100;
            $overheadCost = SettingFixedCost::getFixedCostMonthly() * $percentageForOverhead;

            $totalIngredientCost = $this->calculateIngredientsCost($request);

            $cogs = $salaryPercentage + $overheadCost + $totalIngredientCost;
            if ($cogs <= 0) {
                errCakeCOGS();
            }

            $sellingPrice = $cogs * (1 + $margin);

            return success([
                'overhead' => round(num: $overheadCost),
                'ingredientCost' => round(num: $totalIngredientCost),
                'COGS' => round(num: $cogs),
                'sellingPrice' => round(num: $sellingPrice),
                'profitPerItem' => round(num: $sellingPrice - $cogs),
            ]);
        } catch (\Exception $e) {
            return exception($e);
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|mixed
     */
    public function Restock(Request $request){
        try{
            Validator::make($request->all(), [
                'addStockSell' => 'required|numeric',
                'addStockNonSell' => 'required|numeric',
            ]);

            if(
                ($this->cake->stockSell - abs($request->addStockSell)) < 0 ||
                ($this->cake->stockNonSell - abs($request->addStockNonSell)) < 0
            ){
                errCakeReStock('stock out of range');
            }

            DB::transaction(function() use ($request){
                $this->cake->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                if($request->addStockSell < 0){
                    $this->cake->adjustStockNonSell((-1) * $request->addStockSell);
                }

                if($request->addStockNonSell < 0){
                    $this->cake->adjustStockSell((-1) * $request->addStockNonSell);
                }

                $this->cake->adjustStockSell($request->addStockSell);

                $this->cake->adjustStockNonSell($request->addStockNonSell);

                $this->cake->save();

                if($request->addStockSell > 0 && $request->addStockNonSell > 0){
                    $cakeIngredients = $this->cake->cakeIngredients()->get();
                    foreach($cakeIngredients as $pivot){
                        $ingredient = CakeComponentIngredient::find($pivot->ingredientId);

                        $ingredient->adjustStock((-1) * $request->addStockSell * $pivot->quantity);

                        $ingredient->adjustStock((-1) * $request->addStockNonSell * $pivot->quantity);
                    }
                }

                $this->cake->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Restock Cake : '.$this->cake->id);
            });

            return success($this->cake);
        }catch (\Exception $e) {
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
            $form['stock'] = $this->cake->stock + $request->stock;

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

    private function syncVariantsRelationship($request)
    {
        $variantIds = [];
        foreach($request->variants ?: [] as $variant) {
            $this->cake->variants()->updateOrCreate([
                'id' => $variant['id']
            ], [
                'price' => $variant['price'],
            ]);

            $variantIds[] = $variant['id'];
        }

        $this->cake->variants()
            ->whereNotIn('id', $variantIds)
            ->delete();
    }

    private function syncIngredientsRelationship($request)
    {
        $pivotIds = [];
        foreach($request->ingredients ?: [] as $ingredient) {
            $this->cake->cakeIngredients()->updateOrCreate([
                'ingredientId' => $ingredient['id']
            ], [
                'quantity' => $ingredient['quantity'],
            ]);

            $pivotIds[] = $ingredient['id'];
        }

        $this->cake->cakeIngredients()
            ->whereNotIn('ingredientId', $pivotIds)
            ->delete();
    }

    private function getMarginDecimal(Request $request): float
    {
        if ($request->has('margin') && $request->margin > 0) {
            return (float) $request->margin / 100;
        }

        return Setting::where('key', SettingConstant::PROFIT_MARGIN_KEY)->first()->value / 100;
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

            $totalIngredientCost += ($pricePerUnit * $quantity);
        }

        if ($totalIngredientCost <= 0) {
            errCakeIngredientTotalCost();
        }

        return $totalIngredientCost;
    }

    private function saveCakeImages(Request $request)
    {
        $path = Path::CAKES;
        $images = [];

        foreach ($request->images ?: [] as $key => $reqImage) {
            if ($request->hasFile('images.'.$key.'.file') && $reqImage['file']->isValid()) {
                $filename = filename($reqImage['file'], $this->cake->name);

                if(!$reqImage['file']->move(Path::STORAGE_PUBLIC_PATH($path), $filename)){
                    errCakeUploadImage();
                }

                $images[] = $path.$filename;
            }else if(!empty($reqImage['path']) && is_string($reqImage['path'])){
                $images[] = $reqImage['path'];
            }else{
                errCakeUploadImage(internalMsg: 'Invalid image format');
            }
        }

        $this->deletedImages = array_diff($this->cake->images ?: [], $images);

        $this->cake->images = $images;
        $this->cake->save();
    }

    public function __destruct()
    {
        foreach ($this->deletedImages as $image) {
            if (file_exists(Path::STORAGE_PUBLIC_PATH($image))) {
                unlink(Path::STORAGE_PUBLIC_PATH($image));
            }
        }
    }
}
