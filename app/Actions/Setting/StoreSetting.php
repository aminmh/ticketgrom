<?php

namespace App\Actions\Setting;

use App\Models\Setting;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use PHPUnit\Framework\Assert;

class StoreSetting
{
    public function __construct(protected Request $request)
    {
    }

    public function save(string $scope)
    {
        $setting = $this->user()->setting();

        if (!$setting->exists())
            $setting = new Setting();

        $setting->scope = $scope;

        $setting->setting = $this->request->json('setting');

        $setting->creator()->associate($this->user());

        $setting->save();
    }

    private function user(): \App\Models\User|Authenticatable
    {
        return auth()->user() ?? \App\Models\User::find(1);
    }
}
