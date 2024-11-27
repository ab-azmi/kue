<?php

namespace App\Http\Controllers\Web\Employee;

use App\Algorithms\Employee\EmployeeAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeRequest;
use App\Models\Employee\Employee;
use App\Parser\Employee\EmployeeParser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse|mixed
     */
    public function get(Request $request)
    {
        $employees = Employee::filter($request)->with('user')->getOrPaginate($request, true);

        return success(EmployeeParser::briefs($employees), pagination: pagination($employees));
    }

    /**
     * @param EmployeeRequest $request
     *
     * @return JsonResponse|mixed
     */
    public function create(EmployeeRequest $request)
    {
        $algo = new EmployeeAlgo;
        return $algo->create($request);
    }

    /**
     * @param  string  $id
     *
     * @return JsonResponse|mixed
     */
    public function detail($id)
    {
        $employee = Employee::with(['user', 'salary'])->find($id);
        if (! $employee) {
            errEmployeeGet();
        }

        return success($employee);
    }

    /**
     * @param  string  $id
     * @param EmployeeRequest  $request
     *
     * @return JsonResponse|mixed
     */
    public function update($id, EmployeeRequest $request)
    {
        $algo = new EmployeeAlgo((int) $id);
        return $algo->update($request);
    }

    /**
     * @param  string  $id
     *
     * @return JsonResponse|mixed
     */
    public function delete(string $id)
    {
        $algo = new EmployeeAlgo((int) $id);
        return $algo->delete();
    }
}
