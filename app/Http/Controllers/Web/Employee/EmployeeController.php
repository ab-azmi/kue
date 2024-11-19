<?php

namespace App\Http\Controllers\Web\Employee;

use App\Algorithms\Employee\EmployeeAlgo;
use App\Http\Controllers\Controller;
use App\Models\Employee\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(public $algo = new EmployeeAlgo())
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function get(Request $request)
    {
        $employees = Employee::getOrPaginate($request, true);
        return success($employees);   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        return $this->algo->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id)
    {
        $employee = Employee::find($id);
        return success($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->algo->employee = Employee::find($id);
        return $this->algo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $this->algo->employee = Employee::find($id);
        return $this->algo->delete();
    }
}
