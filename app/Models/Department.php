<?php

namespace App\Models;

use App\Infrastructure\Traits\HasMessage;
use App\Infrastructure\Traits\HasSetting;
use App\Infrastructure\Traits\HaveInbox;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Department extends Model
{

    use HasMessage, Notifiable, HasSetting, HaveInbox;

    protected $table = 'departments';

    protected $fillable = ['name', 'visible_for_customers'];

    protected $dispatchesEvents = [
        'created' => \App\Events\NewDepartment::class
    ];

    protected $attributes = [
        'visible_for_customers' => true
    ];

    public function members()
    {
        return $this->belongsToMany(User::class, 'department_members', 'department_id', 'user_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'ticket_id');
    }

    public function defaultInbox()
    {
        return DB::table('default_inboxes')
            ->where('owner_type', get_class($this))
            ->where('owner_id', $this->getKey())
            ->first();
    }

    public function markAsInvisible()
    {
        return $this->update([
            'visible_for_customers' => false
        ]);
    }
}
