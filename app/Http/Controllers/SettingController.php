<?php

namespace App\Http\Controllers;


use Modules\Setting\Actions\Store as SettingStore;

class SettingController extends Controller
{
    public function store(SettingStore $settingStore)
    {
        try {

            $settingStore->create();

            return response()->json(json_message('SUCCESS'));
            
        } catch (\Throwable $th) {

            dd($th);

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
