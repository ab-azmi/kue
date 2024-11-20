<?php

namespace App\Algorithms\Employee;

use App\Models\Employee\EmployeeSalary;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeSalaryAlgo
{
    public function __construct(public ?EmployeeSalary $salary = null) {}

    public function create(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->salary = EmployeeSalary::create($request->all());

                $this->salary->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new EmployeeSalary : ' . $this->salary->id);
            });

            return success($this->salary);
        } catch (\Exception $e) {
            return errCreateSalary($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                $this->salary->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                EmployeeSalary::where('id', $id)->update($request->all());
                $this->salary = EmployeeSalary::findOrFail($id);

                $this->salary->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update EmployeeSalary : ' . $this->salary->id);
            });

            return success($this->salary);
        } catch (\Exception $e) {
            return errUpdateSalary($e->getMessage());
        }
    }

    public function delete()
    {
        try {
            DB::transaction(function () {
                $this->salary->setOldActivityPropertyAttributes(ActivityAction::DELETE);

                $this->salary->delete();

                $this->salary->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete EmployeeSalary : ' . $this->salary->id);
            });

            return success($this->salary);
        } catch (\Exception $e) {
            return errDeleteSalary($e->getMessage());
        }
    }
}
