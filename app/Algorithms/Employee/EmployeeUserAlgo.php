<?php 

namespace App\Algorithms\Employee;

use App\Models\Employee\EmployeeUser;
use App\Parser\Employee\EmployeeUserParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeUserAlgo
{
    public function __construct(public ?EmployeeUser $user = null){}

    
    public function store(Request $request){
        try {
            DB::transaction(function () use ($request) {
                $this->user = EmployeeUser::create($request->validated());
            });

            return success(EmployeeUserParser::first($this->user));
            
        } catch (\Exception $e) {
            return errCreateUser($e->getMessage());
        }
    }

    public function update(Request $request){
        try {
            DB::transaction(function () use ($request) {
                $this->user->update($request->validated());
            });

            return success(EmployeeUserParser::first($this->user));
        } catch (\Exception $e) {
            return errUpdateUser($e->getMessage());
        }
    }

    public function destroy(){
        try {
            DB::transaction(function () {                
                $this->user->delete();
            });

            return success(EmployeeUserParser::first($this->user));
        } catch (\Exception $e) {
            return errDeleteUser($e->getMessage());
        }
    }
}