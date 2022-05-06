<?php

namespace App\Infrastructure\Traits;


trait SeenStatus
{
    public function markAsSeen()
    {
        $this->update(['seen' => true]);

        $this->fireModelEvent('seen');
    }
}
