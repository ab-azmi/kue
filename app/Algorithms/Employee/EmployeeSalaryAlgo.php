<?php
namespace App\Algorithms\Employee;

use App\Models\Employee\EmployeeSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeSalaryAlgo
{
    public function __construct(public ?EmployeeSalary $salary = null)
    {
        
    }

    public function create(Request $request){
        try {
            DB::transaction(function() use ($request){
                $this->salary = EmployeeSalary::create($request->all());
            });

            return success($this->salary);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function update(Request $request, $id){
        try {
            DB::transaction(function() use ($request, $id){
                EmployeeSalary::where('id', $id)->update($request->all());
                $this->salary = EmployeeSalary::findOrFail($id);
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