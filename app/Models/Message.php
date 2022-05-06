<?php

namespace App\Models;

use App\Infrastructure\Traits\SeenStatus;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    use SeenStatus;

    protected $table = 'messages';

    public $fillable = ['message', 'status_id'];

    protected $dateFormat = TIMESTAMP_FORMAT;

    public function messageable()
    {
        return $this->morphTo('send_to');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
