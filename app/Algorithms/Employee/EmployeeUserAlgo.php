<?php 

namespace App\Algorithms\Employee;

use App\Models\Employee\EmployeeUser;
use App\Parser\User\UserParser;
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

            return success(UserParser::first($this->user));
            
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function update(Request $request){
        try {
            DB::transaction(function () use ($request) {
                $this->user->update($request->validated());
            });

            return success(UserParser::first($this->user));
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function destroy(){
        try {
            DB::transaction(function () {                
                $this->user->delete();
            });

            return success(UserParser::first($this->user));
        } catch (\Exception $e) {
            exception($e);
        }
    }
}