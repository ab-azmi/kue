<?php

namespace App\Http\Controllers\Web\Employee;

use App\Algorithms\Employee\EmployeeSalaryAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeSalaryRequest;
use App\Models\Employee\EmployeeSalary;
use App\Parser\Employee\EmployeeSalaryParser;
use Illuminate\Http\Request;

class EmployeeSalaryController extends Controller
{
    /**
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $salaries = EmployeeSalary::with('employee')
            ->getOrPaginate($request, true);
        return success(EmployeeSalaryParser::briefs($salaries));
    }

    /**
     * @param App\Http\Requests\Employee\EmployeeSalaryRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(EmployeeSalaryRequest $request)
    {
        $algo = new EmployeeSalaryAlgo();
        return $algo->create($request);
    }

    /**
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $salary = EmployeeSalary::with('employee')->find($id);
        if (!$salary) {
            return errGetSalary();
        }

        return success(EmployeeSalaryParser::first($salary));
    }

    /**
     * @param string|int $id
     * @param App\Http\Requests\Employee\EmployeeSalaryRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, EmployeeSalaryRequest $request)
    {
        $algo = new EmployeeSalaryAlgo((int)$id);
        return $algo->update($request);
    }

    /**
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $algo = new EmployeeSalaryAlgo((int)$id);
        return $algo->delete();
    }
}
