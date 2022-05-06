<?php

namespace App\Infrastructure\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasSetting
{

    public function setting(): MorphMany
    {
        return $this->morphMany(\Modules\Setting\Model\Setting::class, 'settingable');
    }
}
