<?php

namespace App\Infrastructure\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasFavorite
{

    public function favorites(): MorphMany
    {
        return $this->morphMany(\App\Models\Favorite::class, 'favoritable');
    }

    public function markAsFavorite()
    {
        (new \App\Models\Favorite)->favoritable()
            ->associate($this)->save();
    }
}
