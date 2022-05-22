<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = "ticket_statuses";

    protected $fillable = ['status'];

    public $timestamps = false;

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'status');
    }
}
