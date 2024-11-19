<?php
 namespace App\Algorithms\Setting;

use App\Models\Setting\Setting;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

 class SettingAlgo
 {
    public function __construct(public ?Setting $setting = null)
    {
    }

    public function create(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->setting = Setting::create($request->only(['key', 'description', 'value']));
                
                $this->setting->setActivityPropertyAttributes(ActivityAction::CREATE)
                ->saveActivity('Create new Setting : ' . $this->setting->id);
            });

            return success($this->setting);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                $this->setting = Setting::find($id);
                
                $this->setting->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                Setting::where('id', $id)->update($request->only(['key', 'description', 'value']));
                $this->setting->refresh();
                
                $this->setting->setActivityPropertyAttributes(ActivityAction::UPDATE)
                ->saveActivity('Update Setting : ' . $this->setting->id);
            });

            return success($this->setting);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function delete()
    {
        try {
            DB::transaction(function () {
                $this->setting->setOldActivityPropertyAttributes(ActivityAction::DELETE);
                $this->setting->delete();
                $this->setting->setActivityPropertyAttributes(ActivityAction::DELETE)
                ->saveActivity('Delete Setting : ' . $this->setting->id);
            });

            return success($this->setting);
        } catch (\Exception $e) {
            exception($e);
        }
    }
 }