<?php
namespace App\Algorithms\Salary;

use App\Models\Salary\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryAlgo
{
    public function __construct(public ?Salary $salary = null)
    {
        
    }

    public function create(Request $request){
        try {
            DB::transaction(function() use ($request){
                $this->salary = Salary::create($request->all());
            });

            return success($this->salary);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function update(Request $request){
        try {
            DB::transaction(function() use ($request){
                $this->salary->update($request->all());
            });

            return success($this->salary);
        } catch (\Exception $e) {
            exception($e);
        }
    }
    
    public function delete(){
        try {
            DB::transaction(function(){
                $this->salary->delete();
            });

            return success($this->salary);
        } catch (\Exception $e) {
            exception($e);
        }
    }
}