<?php

namespace Modules\Setting\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'setting';

    protected $fillable = ['user_id', 'setting', 'type'];

    public $timestamps = false;

    public function settingable()
    {
        return $this->morphTo();
    }

    public static function defaultUserSetting()
    {
        return (object)["ticket" => [
            "notification" =>  [
                "broadcast" =>  [
                    "show" => true,
                    "message" => "شما تیکت جدید دریافت کردید"
                ]

            ],
            "message" => [
                "notification" => [
                    "broadcast" => [
                        "show" => true,
                        "message" => "شما پیام جدید دریافت کردید"
                    ]
                ]
            ]
        ]];
    }

    protected function setting(): Attribute
    {
        return Attribute::get(
            fn ($setting) => json_decode($setting)
        );
    }
}
