<?php

namespace App\Algorithms\Employee;

use App\Models\Employee\EmployeeUser;
use App\Parser\Employee\EmployeeUserParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeUserAlgo
{
    public function __construct(public EmployeeUser|int|null $user = null)
    {
        if (is_int($user)) {
            $this->user = EmployeeUser::find($user);
            if (!$this->user) {
                return errGetUser();
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
                $this->saveUser($request);
            });

            return success(EmployeeUserParser::first($this->user));
        } catch (\Exception $e) {
            return errCreateUser($e->getMessage());
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
                $this->saveUser($request);
            });

            return success(EmployeeUserParser::first($this->user));
        } catch (\Exception $e) {
            return errUpdateUser($e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        try {
            DB::transaction(function () {
                $this->user->delete();
            });

            return success(EmployeeUserParser::first($this->user));
        } catch (\Exception $e) {
            return errDeleteUser($e->getMessage());
        }
    }

    /** --- PRIVATE FUNCTION --- **/

    private function saveUser($request)
    {
        if ($this->user) {
            $form = $request->safe()->only([
                'name', 'email', 'password', 'role'
            ]);

            $updated = $this->user->update($form);
            if (!$updated) {
                return errUpdateUser();
            }
        }else{
            $form = $request->safe()->only([
                'name', 'email'
            ]);

            $this->user = EmployeeUser::create($form);
            if (!$this->user) {
                return errCreateUser();
            }
        }
    }
}
