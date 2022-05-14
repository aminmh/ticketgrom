<?php

namespace App\Infrastructure\Traits;


trait SeenStatus
{
    public function markAsSeen()
    {
        $this->fireModelEvent('seen');
    }
}
