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
}