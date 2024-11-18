<?php 

namespace App\Algorithms\User;

use App\Models\User\User;
use App\Parser\User\UserParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAlgo
{
    public function __construct(public ?User $user = null){}

    
    public function store(Request $request){
        try {
            DB::transaction(function () use ($request) {
                $this->user = User::create($request->validated());
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