<?php

namespace App\Algorithms\Employee;

use App\Models\Employee\EmployeeSalary;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeSalaryAlgo
{
    public function __construct(public EmployeeSalary|int|null $salary = null)
    {
        if (is_int($salary)) {
            $this->salary = EmployeeSalary::find($salary);
            if (!$this->salary) {
                errGetSalary();
            }
        }
    }

    public function create(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->saveSalary($request);

                $this->salary->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new EmployeeSalary : ' . $this->salary->id);
            });

            return success($this->salary);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function update(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->salary->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->saveSalary($request);

                $this->salary->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update EmployeeSalary : ' . $this->salary->id);
            });

            return success($this->salary);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function delete()
    {
        try {
            DB::transaction(function () {
                $this->salary->setOldActivityPropertyAttributes(ActivityAction::DELETE);

                $deleted = $this->salary->delete();
                if (!$deleted) {
                    errDeleteSalary();
                }

                $this->salary->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete EmployeeSalary : ' . $this->salary->id);
            });

            return success($this->salary);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /** --- PRIVATE FUNCTIONS --- **/

    private function saveSalary($request)
    {
        $form = $request->safe()->only([
            'totalSalary',
            'employeeId',
        ]);

        if($this->salary) {
            $updated = $this->salary->update($form);
            if(!$updated) {
                errUpdateSalary();
            }
        } else {
            $this->salary = EmployeeSalary::create($form);
            if(!$this->salary) {
                errCreateSalary();
            }
        }
    }
}
