<?php

namespace App\Algorithms\Employee;

use App\Models\Employee\Employee;
use App\Services\Constant\Activity\ActivityAction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeAlgo
{
    public function  __construct(public Employee|int|null $employee = null)
    {
        if (is_int($employee)) {
            $this->employee = Employee::find($employee);
            if (!$this->employee) {
                errGetEmployee();
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->saveEmployee($request);

                $this->employee->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Employee : ' . $this->employee->id);
            });

            return success($this->employee);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->employee->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->saveEmployee($request);

                $this->employee->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Employee : ' . $this->employee->id);
            });

            return success($this->employee);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete()
    {
        try {
            DB::transaction(function () {
                $this->employee->setOldActivityPropertyAttributes(ActivityAction::DELETE);

                $deleted = $this->employee->delete();
                if (!$deleted) {
                    errDeleteEmployee();
                }

                $this->employee->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Employee : ' . $this->employee->id);
            });

            return success($this->employee);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /** --- PRIVATE FUNCTIONS --- **/

    private function saveEmployee(Request $request)
    {
        $form = $request->safe()->only([
            'phone',
            'address',
            'bankNumber',
            'userId',
        ]);

        if($this->employee){
            $updated = $this->employee->update($form);
            if (!$updated) {
                errUpdateEmployee();
            }
        } else {
            $this->employee = Employee::create($form);
            if (!$this->employee) {
                errCreateEmployee();
            }
        }
    }
}
