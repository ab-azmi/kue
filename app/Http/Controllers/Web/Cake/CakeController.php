<?php

namespace App\Http\Controllers\Web\Cake;

use App\Algorithms\Cake\CakeAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cake\CakeCOGSRequest;
use App\Http\Requests\Cake\CakeRequest;
use App\Models\Cake\Cake;
use App\Parser\Cake\CakeParser;
use App\Services\Constant\Path\Path;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CakeController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse|mixed
     */
    public function get(Request $request)
    {
        $cakes = Cake::filter($request)->getOrPaginate($request, true);

        return success(CakeParser::briefs($cakes), pagination:pagination($cakes));
    }

    /**
     * @param  string  $id
     *
     * @return JsonResponse|mixed
     */
    public function detail($id)
    {
        $cake = Cake::with([
            'variants',
            'discounts',
        ])->find($id);

        if (! $cake) {
            errCakeGet();
        }

        return success($cake);
    }

    /**
     * @param CakeRequest $request
     *
     * @return JsonResponse|mixed
     */
    public function create(CakeRequest $request)
    {
        $algo = new CakeAlgo;
        return $algo->create($request);
    }

    /**
     * @param  string  $id
     * @param  CakeRequest  $request
     *
     * @return JsonResponse|mixed
     */
    public function update($id, CakeRequest $request)
    {
        $algo = new CakeAlgo((int) $id);
        return $algo->update($request);
    }

    /**
     * @param  string  $id
     *
     * @return JsonResponse
     */
    public function delete($id)
    {
        $algo = new CakeAlgo((int) $id);
        return $algo->delete();
    }

    /**
     * @return JsonResponse|mixed
     */
    public function COGS(CakeCOGSRequest $request)
    {
        $algo = new CakeAlgo;
        return $algo->COGS($request);
    }
}
