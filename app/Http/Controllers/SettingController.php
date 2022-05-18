<?php

namespace App\Http\Controllers;

use App\Actions\Setting\StoreSetting;

class SettingController extends Controller
{
    public function store(StoreSetting $storeSetting, string $scope)
    {
        try {

            $storeSetting->save($scope);

            return response()->json(json_message('SUCCESS'));

        } catch (\Throwable $th) {

            return response()->json(['error' => $th->getMessage()], 500);
            
            dd($th);
        }
    }
}
