<?php

namespace App\Http\Controllers\Web\Employee;

use App\Algorithms\Employee\EmployeeSalaryAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeSalaryRequest;
use App\Models\Employee\EmployeeSalary;
use App\Parser\Salary\EmployeeSalaryParser;
use Illuminate\Http\Request;

class EmployeeSalaryController extends Controller
{
    public function __construct(public $algo = new EmployeeSalaryAlgo())
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function get(Request $request)
    {
        $salaries = EmployeeSalary::with('user')->getOrPaginate($request, true);
        return success(EmployeeSalaryParser::briefs($salaries));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(EmployeeSalaryRequest $request)
    {
        return $this->algo->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id)
    {
        $salary = EmployeeSalary::with('user')->findOrFail($id);
        return success(EmployeeSalaryParser::first($salary));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeSalaryRequest $request, string $id)
    {
        return $this->algo->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $this->algo->salary = EmployeeSalary::findOrFail($id);
        return $this->algo->delete();
    }
}
