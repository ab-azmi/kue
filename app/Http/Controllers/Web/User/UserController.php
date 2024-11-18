<?php

namespace App\Http\Controllers\Web\User;

use App\Algorithms\User\UserAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\User\CreateUserRequest;
use App\Http\Requests\v1\User\UpdateUserRequest;
use App\Models\v1\User\User;
use App\Parser\User\UserParser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // constructor
    public function __construct(public $algo = new UserAlgo()){
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::orderBy('id', 'DESC')->getOrPaginate($request, true);
        return success($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        return $this->algo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return success(UserParser::first($user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $this->algo->user = $user;
        return $this->algo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $this->algo->user = $user;
        return $this->algo->destroy();
    }
}
