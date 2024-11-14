<?php
namespace App\Algorithms\v1\Salary;

use App\Models\v1\Salary\Salary;
use App\Services\Constant\Activity\ActivityAction;
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
                
                $this->salary->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Salary : ' . $this->salary->id);
            });

            return success($this->salary);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function update(Request $request){
        try {
            DB::transaction(function() use ($request){
                $this->salary->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->salary->update($request->all());

                $this->salary->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Salary : ' . $this->salary->id);
            });

            return success($this->salary);
        } catch (\Exception $e) {
            exception($e);
        }
    }
    
    public function delete(){
        try {
            DB::transaction(function(){
                $this->salary->setOldActivityPropertyAttributes(ActivityAction::DELETE);

                $this->salary->delete();

                $this->salary->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Salary : ' . $this->salary->id);
            });

            return success($this->salary);
        } catch (\Exception $e) {
            exception($e);
        }
    }
}