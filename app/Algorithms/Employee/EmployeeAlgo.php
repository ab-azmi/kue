<?php

namespace App\Algorithms\Employee;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeUser;
use App\Parser\Employee\EmployeeParser;
use App\Services\Constant\Activity\ActivityAction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeAlgo
{
    /**
     * @param Employee|int|null
     */
    public function  __construct(public Employee|int|null $employee = null)
    {
        if (is_int($employee)) {
            $this->employee = Employee::with([
                'user',
                'salary'
            ])->find($employee);
            if (!$this->employee) {
                errEmployeeGet();
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
                $request = $this->saveUser($request);
                $this->saveEmployee($request);
                $this->saveSalary($request);

                $this->employee->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Employee : ' . $this->employee->id);
            });

            return success(EmployeeParser::first($this->employee));
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

                $request = $this->saveUser($request);
                $this->saveEmployee($request);
                $this->saveSalary($request);

                $this->employee->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Employee : ' . $this->employee->id);
            });

            return success(EmployeeParser::first($this->employee));
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

                $this->deleteEmployeeData();

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
        $form = $request->only([
            'phone',
            'address',
            'bankNumber',
            'userId',
            'userId'
        ]);

        if ($this->employee) {
            $updated = $this->employee->update($form);
            if (!$updated) {
                errEmployeeUpdate();
            }
        } else {
            $this->employee = Employee::create($form);
            if (!$this->employee) {
                errEmployeeCreate();
            }
        }
    }

    private function saveUser(Request $request)
    {
        $form = $request->safe()->only([
            'name',
            'email',
            'password',
            'role',
        ]);

        if ($this->employee) {
            $updated = $this->employee->user->update($form);
            if (!$updated) {
                errEmployeeUserUpdate();
            }
        } else {
            $user = EmployeeUser::create($form);
            if (!$user) {
                errEmployeeUserCreate();
            }

            $request['userId'] = $user->id;
        }
        return $request;
    }

    private function saveSalary(Request $request)
    {
        $form = $request->safe()->only([
            'totalSalary',
        ]);


        if ($this->employee) {
            $form['employeeId'] = $this->employee->id;

            $this->employee->salary()->delete();
            
            $updated = $this->employee->salary()->create($form);
            if (!$updated) {
                errEmployeeSalaryUpdate();
            }
        }
    }

    private function deleteEmployeeData()
    {
        $deleteEmployee = $this->employee->delete();
        if (!$deleteEmployee) {
            errEmployeeDelete();
        }
        
        $deleteSalary = $this->employee->salary->delete();
        if (!$deleteSalary) {
            errEmployeeSalaryDelete();
        }
    }
}
