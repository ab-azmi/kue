<?php 

namespace App\Algorithms\v1\User;

use App\Models\v1\User\User;
use App\Parser\User\UserParser;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAlgo
{
    public function __construct(public ?User $user = null){}

    
    public function store(Request $request){
        try {
            DB::transaction(function () use ($request) {
                $this->user = User::create($request->validated());
                
                $this->user->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new User : ' . $this->user->id);
            });

            return success(UserParser::first($this->user));
            
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function update(Request $request){
        try {
            DB::transaction(function () use ($request) {
                $this->user->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->user->update($request->validated());
                
                $this->user->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update User : ' . $this->user->id);
            });

            return success(UserParser::first($this->user));
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function destroy(){
        try {
            DB::transaction(function () {
                $this->user->setOldActivityPropertyAttributes(ActivityAction::DELETE);
                
                $this->user->delete();
                
                $this->user->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete User : ' . $this->user->id);
            });

            return success(UserParser::first($this->user));
        } catch (\Exception $e) {
            exception($e);
        }
    }
}