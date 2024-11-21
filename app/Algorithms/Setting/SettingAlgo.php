<?php
 namespace App\Algorithms\Setting;

use App\Models\Setting\Setting;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

 class SettingAlgo
 {
    public function __construct(public Setting|int|null $setting = null)
    {
        if(is_int($setting)){
            $this->setting = Setting::find($setting);
            if(!$this->setting){
                errGetSetting();
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->setting->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->saveSetting($request);
                
                $this->setting->setActivityPropertyAttributes(ActivityAction::UPDATE)
                ->saveActivity('Update Setting : ' . $this->setting->id);
            });

            return success($this->setting);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /** --- PRIVATE FUNCTIONS --- **/
    
    private function saveSetting($request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'value' => 'required'
        ]);

        $form = $request->only(['description', 'value']);

        if($this->setting)
        {
            $updated = $this->setting->update($form);
            if(!$updated){
                errUpdateSetting();
            }
        }
    }
 }