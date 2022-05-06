<?php

namespace App\Infrastructure\Traits;

use App\Models\Message;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMessage
{

    public function messages(): MorphMany
    {
        return $this->morphMany(Message::class, 'messageable', 'send_to_type', 'send_to_id');
    }
}
