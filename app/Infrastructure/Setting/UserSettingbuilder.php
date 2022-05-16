<?php

namespace App\Infrastructure\Setting;

use ArrayAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Serializable;
use \Illuminate\Support\Collection;

class UserSettingBuilder
{
    protected Collection $setting;

    public function __construct(protected Model $model)
    {
    }

    public static function for(Model $model)
    {
        return new static($model);
    }

    public function ticketNotificationToggle(bool|int $toggle)
    {
        $this->setting->mergeRecursive([
            'notification' => [
                'ticket' => is_bool($toggle)
                    ? $toggle
                    : $this->resolveTimestamp($toggle)
            ]
        ]);

        return $this;
    }

    public function messageNotificationToggle(bool|int $toggle)
    {
        $this->setting->mergeRecursive([
            'notification' => [
                'message' => is_bool($toggle)
                    ? $toggle
                    : $this->resolveTimestamp($toggle)
            ]
        ]);

        return $this;
    }

    public function muteNotifications()
    {
        $this->ticketNotificationToggle(false);

        $this->messageNotificationToggle(false);
    }

    public function __set($name, $value)
    {
    }

    public function __get($name)
    {
    }

    private function resolveTimestamp(int $interval)
    {
        return Carbon::now(TIMEZONE)
            ->addMinutes($interval)
            ->format(TIMESTAMP_FORMAT);
    }
}
