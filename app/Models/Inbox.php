<?php

namespace App\Models;

use Domain\Ticket\Models\Ticket;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inbox extends Model
{

    protected $table = "inboxes";

    protected $fillable = [
        'name', 'email', 'id'
    ];

    public $timestamps = false;

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'inbox_id');
    }

    public function owner()
    {
        return $this->morphTo('owner');
    }

    public function saveAsDefault(): bool
    {
        // dd($this->owner_type,$this->owner_id,$this);
        parent::save();
        return DB::table('default_inboxes')->insert([
            'owner_id' => $this->owner_id,
            'owner_type' => $this->owner_type,
            'inbox_id' => $this->getKey(),
        ]);
    }

    public function scopeVisible(Builder $query, int $agentId)
    {
        $query->whereNotIn('id', DB::table('inbox_permissions')
            ->where('agent_id', $agentId)
            ->pluck('inbox_id'));
    }
}
