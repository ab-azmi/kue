<?php

namespace App\Http\Controllers\Web\Employee;

use App\Algorithms\Employee\EmployeeAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeRequest;
use App\Models\Employee\Employee;
use App\Parser\Employee\EmployeeParser;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $employees = Employee::getOrPaginate($request, true);
        return success($employees);   
    }

    /**
     * @param App\Http\Requests\Employee\EmployeeRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(EmployeeRequest $request)
    {
        $algo = new EmployeeAlgo();
        return $algo->create($request);
    }

    /**
     * @param string|int $id
     */
    public function detail($id)
    {
        $employee = Employee::with(['user', 'salary'])->find($id);
        if (!$employee) {
            errGetEmployee();
        }

        return success(EmployeeParser::first($employee));
    }

    /**
     * @param string|int $id
     * @param App\Http\Requests\Employee\EmployeeRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, EmployeeRequest $request)
    {
        $algo = new EmployeeAlgo((int)$id);
        return $algo->update($request);
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(string $id)
    {
        $algo = new EmployeeAlgo((int)$id);
        return $algo->delete();
    }
}
