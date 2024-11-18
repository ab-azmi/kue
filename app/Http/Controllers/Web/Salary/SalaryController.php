<?php

namespace App\Http\Controllers\Web\Salary;

use App\Algorithms\Salary\SalaryAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Salary\SalaryRequest;
use App\Models\v1\Salary\Salary;
use App\Parser\Salary\SalaryParser;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function __construct(public $algo = new SalaryAlgo())
    {
        //
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $salaries = Salary::with('user')->getOrPaginate($request, true);
        return success(SalaryParser::get($salaries));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalaryRequest $request)
    {
        return $this->algo->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $salary = Salary::with('user')->findOrFail($id);
        return success(SalaryParser::first($salary));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalaryRequest $request, string $id)
    {
        $this->algo->salary = Salary::findOrFail($id);
        return $this->algo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->algo->salary = Salary::findOrFail($id);
        return $this->algo->delete();
    }
}
