<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{

    protected $table = "favorites";

    public $timestamps = false;

    public function favoritable()
    {
        return $this->morphTo();
    }
}
