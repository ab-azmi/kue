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
        $user = EmployeeUser::findOrFail($id);
        return success(EmployeeUserParser::first($user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeUserRequest $request, string $id)
    {
        $user = EmployeeUser::findOrFail($id);
        $this->algo->user = $user;
        return $this->algo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $user = EmployeeUser::findOrFail($id);
        $this->algo->user = $user;
        return $this->algo->destroy();
    }
}
