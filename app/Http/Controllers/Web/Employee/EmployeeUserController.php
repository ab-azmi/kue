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
    // constructor
    public function __construct(public $algo = new EmployeeUserAlgo()){
    }
    /**
     * Display a listing of the resource.
     */
    public function get(Request $request)
    {
        $users = EmployeeUser::orderBy('id', 'DESC')->getOrPaginate($request, true);
        return success(EmployeeUserParser::briefs($users));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(CreateEmployeeUserRequest $request)
    {
        return $this->algo->store($request);
    }

    /**
     * Display the specified resource.
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
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeUserRequest $request, string $id)
    {
        $this->algo->user = EmployeeUser::find($id);

        if (!$this->algo->user) {
            return errGetUser();
        }

        return $this->algo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $this->algo->user = EmployeeUser::findOrFail($id);

        if (!$this->algo->user) {
            return errGetUser();
        }

        return $this->algo->destroy();
    }
}
