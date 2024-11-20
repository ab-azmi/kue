<?php

namespace App\Algorithms\Employee;

use App\Models\Employee\Employee;
use App\Services\Constant\Activity\ActivityAction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeAlgo
{
    public function  __construct(public ?Employee $employee = null) {}

    public function create(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->employee = Employee::create($request->all());

                $this->employee->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Employee : ' . $this->employee->id);
            });

            return success($this->employee);
        } catch (\Exception $e) {
            return errCreateEmployee($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            DB::transaction(function () use ($request)
            {
                $this->employee->setOldActivityPropertyAttributes(ActivityAction::UPDATE);
                
                $this->employee->update($request->all());
                
                $this->employee->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Employee : ' . $this->employee->id);
            });

            return success($this->employee);
        } catch (\Exception $e) {
            return errUpdateEmployee($e->getMessage());
        }
    }

    public function delete()
    {
        try {
            DB::transaction(function () {
                $this->employee->setOldActivityPropertyAttributes(ActivityAction::DELETE);
                
                $this->employee->delete();
                
                $this->employee->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Employee : ' . $this->employee->id);
            });

            return success($this->employee);
        } catch (\Exception $e) {
            return errDeleteEmployee($e->getMessage());
        }
    }
}
