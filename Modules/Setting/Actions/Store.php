<?php

namespace Modules\Setting\Actions;

use App\Models\User;
use Exception;
use Modules\Setting\Enums\Permissions;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Modules\Setting\Model\Setting;

class Store
{

    public function __construct(protected Request $request)
    {
    }

    public function create()
    {

        $setting = empty($this->request->setting)
            ? Setting::defaultUserSetting()
            : $this->request->setting;

        $this->validation();

        Setting::upsert([
            [
                'user_id' => (int)$this->user()->id,
                'setting' => json_encode($setting,)
            ]
        ], ['user_id'], ['setting']);
    }

    private function validation()
    {

        $validator = new \JsonSchema\Validator();

        $setting = json_encode($this->request->setting, JSON_PRETTY_PRINT);

        $setting = (object)json_decode($setting);

        $validator->validate($setting, (object)[
            '$ref' => 'file://' . $this->schemaPath()
        ]);

        if (!$validator->isValid())
            throw new \JsonSchema\Exception\InvalidSchemaException(__('messages.INVALID_SETTING', [], 'fa'), 400);
    }

    private function user(): \App\Models\User
    {
        // if (auth()->check())
        return auth()->user() ?? User::find(2);
        throw new AuthenticationException(__('messages.UNAUTHENTICATED', [], 'fa'));
    }

    private function schemaPath()
    {
        if ($this->user()->hasRole('admin'))
            return realpath(config('setting.schema.app_setting'));

        if ($this->user()->hasRole('customer'))
            return realpath(config('setting.schema.user_setting'));

        throw new Exception();
    }
}
