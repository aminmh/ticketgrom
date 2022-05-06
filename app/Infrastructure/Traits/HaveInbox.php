<?php

namespace App\Infrastructure\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

trait HaveInbox
{
    public function inboxes(): MorphMany
    {
        return $this->morphMany(\App\Models\Inbox::class, 'haveInbox', 'owner_type', 'owner_id');
    }

    // public function saveAsDefault()
    // {
    //     DB::table('default_inboxes')->insert([]);
    // }
}
