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

class CakeAlgo
{
    /**
     * @var array
     */
    protected array $removeImages = [];


    /**
     * @param Cake|int|null $cake
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $request['ingredients'] = $this->encodeIngredientJSON($request);

                $this->saveCake($request);

                $this->syncIngredientsRelationship($request);

                $this->syncIngredientStock($request);

                $this->saveCakeImages($request);

                $this->cake->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Cake : ' . $this->cake->id);

            });

            return success(CakeParser::first($this->cake));
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {

        try {
            DB::transaction(function () use ($request) {
                $request['ingredients'] = $this->encodeIngredientJSON($request);

                $this->cake->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->saveCake($request);

                $oldIngredients = $this->cake->ingredients;

                $this->syncIngredientsRelationship($request);

                $this->syncIngredientStock($request, $oldIngredients);

                $this->saveCakeImages($request);

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
                $this->detachIngredients($ids);

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function COGS(Request $request)
    {
        try {

            $margin = $this->getMarginDecimal($request);

            $salarySum = EmployeeSalary::getTotalSalary();

            $fixedCostMonthly = SettingFixedCost::getFixedCostMonthly();

            $totalIngredientCost = $this->calculateIngredientsCost($request);

            $cogs = $salarySum + $fixedCostMonthly + $totalIngredientCost;
            $sellingPrice = $cogs * (1 + $margin);

            return success([
                'COGS' => $cogs,
                'sellingPrice' => $sellingPrice,
                'profitPerItem' => $sellingPrice - $cogs,
            ]);

        } catch (\Exception $e) {
            return exception($e);
        }
    }

    public function __destruct()
    {
        if (count($this->removeImages) > 0) {
            foreach ($this->removeImages as $removeImage) {
                unlink(Path::STORAGE_PUBLIC_PATH($removeImage));
            }
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
            if (!$updated) {
                errCakeUpdate();
            }

            return;
        }

        $this->cake = Cake::create($form);
        if (!$this->cake) {
            errCakeCreate();
        }
    }

    private function syncIngredientsRelationship($request)
    {
        $pivotIds = [];
        foreach ($request->ingredients as $ingredient) {
            $componentIngredient = CakeComponentIngredient::find($ingredient['ingredientId']);
            if (!$componentIngredient) {
                errCakeIngredientGet();
            }

            // Assigne logic
            $pivot = $this->cake->ingredients()->updateOrCreate(
                [
                    'ingredientId' => $ingredient['ingredientId']
                ],
                [
                    ''
                ]
            );
            $pivotIds[] = $pivot->id;

            $componentIngredient->adjustQuantity(($ingredient['quantity'] * $this->cake->stock) * -1);
        }

        $deletedPivots = $this->cake->ingredients()->whereNotIn('id', $pivotIds)->with('ingredient')->get();
        foreach ($deletedPivots as $deletedPivot) {
            $deletedPivot->delete();
        }
    }

    private function detachIngredients($toDetach)
    {
        DB::table('cake_ingredients')
            ->where('cakeId', $this->cake->id)
            ->whereIn('ingredientId', $toDetach)
            ->delete();
    }

    private function attachIngredients($request, $toAttach)
    {
        $pivotRows = array_map(function ($id) use ($request) {
            $ingredient = $request->ingredients[array_search($id, array_column($request->ingredients, 'ingredientId'))];

            return [
                'cakeId' => $this->cake->id,
                'ingredientId' => $id,
                'quantity' => $ingredient->quantity,
                'createdAt' => now(),
                'updatedAt' => now(),
            ];
        }, $toAttach);

        DB::table('cake_ingredients')->insert($pivotRows);
    }

    private function syncIngredientStock($request, $oldIngredients = null)
    {
        if ($oldIngredients) {
            $this->incrementIngredientStock($oldIngredients);
        }

        foreach ($request->ingredients as $ingredient) {

            $ingredientModel = $this->cake->ingredients()->find($ingredient->ingredientId);
            if (!$ingredientModel) {
                errCakeIngredientGet();
            }

            $decremented = $ingredientModel->decrementStock(($ingredient->quantity * $this->cake->stock));
            if (!$decremented) {
                errCakeIngredientDecrementStock();
            }
        }
    }

    private function incrementIngredientStock($oldIngredients)
    {
        foreach ($oldIngredients as $oldIngredient) {
            $usedQuantity = $oldIngredient->used->quantity * $this->cake->stock;

            $incremented = $oldIngredient->incrementStock($usedQuantity);
            if (!$incremented) {
                errCakeIngredientDecrementStock();
            }
        }
    }

    private function getMarginDecimal(Request $request): float
    {
        if ($request->has('margin') && $request->margin) {
            return (float)$request->margin;
        }

        return Setting::where('key', SettingConstant::PROFIT_MARGIN_KEY)->first()?->value;
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
        $path = Path::CAKE;

        $images = [];
        foreach ($request->images ?: [] as $key => $imageReq) {
            if ($request->hasFile("images.$key.file") && $request->file("images.$key.file")->isValid()) {
                $image = $request->file("images.$key.file");

                $filename = filename($image, $this->cake->name);

                if (!$image->move(Path::STORAGE_PUBLIC_PATH($path), $filename)) {
                    errCakeUploadImage("images.$key.file");
                }

                $images[] = $path . $filename;

            } elseif (!empty($imageReq['path']) && is_string($imageReq['path'])) {
                $images[] = $imageReq['path'];
            } else {
                errCakeUploadImage("aksjhdfkjlsdfh");
            }
        }

        $this->removeImages = array_diff($this->cake->images ?: [], $images);

        $this->cake->images = $images;
        $this->cake->save();
    }

    private function getFileName($originalName): string
    {
        $rand = rand(1000, 9999);

        $time = time();

        $fileName = str_replace(' ', '_', $originalName);

        return $time . $rand . '_' . $fileName;
    }

    private function encodeIngredientJSON($request)
    {
        return array_map(function ($ingredient) {
            return json_decode($ingredient);
        }, $request->ingredients);
    }
}
