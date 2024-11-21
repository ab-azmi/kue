<?php

namespace App\Http\Controllers\Web\Employee;

use App\Algorithms\Employee\EmployeeUserAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeUser\CreateEmployeeUserRequest;
use App\Http\Requests\Employee\EmployeeUser\UpdateEmployeeUserRequest;
use App\Models\Employee\EmployeeUser;
use App\Parser\Employee\EmployeeUserParser;
use Illuminate\Http\Request;

class EmployeeUserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $users = EmployeeUser::orderBy('id', 'DESC')->getOrPaginate($request, true);
        return success(EmployeeUserParser::briefs($users));
    }

    /**
     * @param App\Http\Requests\Employee\EmployeeUser\CreateEmployeeUserRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateEmployeeUserRequest $request)
    {
        $algo = new EmployeeUserAlgo();
        return $algo->create($request);
    }

    /**
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $user = EmployeeUser::find($id);
        if (!$user) {
            return errGetUser();
        }

        return success(EmployeeUserParser::first($user));
    }

    /**
     * @param App\Http\Requests\Employee\EmployeeUser\UpdateEmployeeUserRequest;
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateEmployeeUserRequest $request)
    {
        $algo = new EmployeeUserAlgo((int)$id);
        return $algo->update($request);
    }

    /**
     * @param string|int $id
     */
    public function delete($id)
    {
        $algo = new EmployeeUserAlgo((int)$id);
        return $algo->destroy();
    }
}
