<?php

namespace App\Models;

use App\Infrastructure\Traits\{HasMessage, HasSetting, SeenStatus, HasFavorite};
use App\Models\User;
use Database\Factories\TicketFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;

/**
 * @method \Illuminate\Database\Eloquent\Builder fromCustomer()
 * @method \Illuminate\Database\Eloquent\Builder seen(bool $seen = false)
 */
class Ticket extends Model
{

    use HasMessage,
        HasSetting,
        HasFactory,
        Notifiable,
        SeenStatus,
        SoftDeletes,
        HasFavorite;

    protected $table = "tickets";

    public $fillable = [
        'text',
        'subject',
        'status',
        'bcc',
        'cc',
        'inbox_id',
        'satisfaction',
        'priority',
        'attached',
        'seen'
    ];

    protected $dateFormat = TIMESTAMP_FORMAT;

    protected $dispatchesEvents = [
        'created' => \App\Events\NewTicket::class
    ];

    protected static function booted()
    {
        static::addGlobalScope(\App\Models\Scopes\OpenedTickets::class);
    }

    protected static function newFactory()
    {
        return TicketFactory::new();
    }

    public function inbox()
    {
        return $this->belongsTo(\App\Models\Inbox::class, 'inbox_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    protected function priority(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => match ($value) {
                0 => 'none',
                1 => 'low',
                2 => 'medium',
                3 => 'hight',
                default => 'none'
            },
            set: fn ($newValue) => match ($newValue) {
                'none' => 0,
                'low' => 1,
                'medium' => 2,
                'hight' => 3,
                default => 0
            }
        );
    }

    protected function cc(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => unserialize($value),
            set: fn ($newValue) => serialize(Arr::wrap($newValue))
        );
    }

    protected function bcc(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => unserialize($value),
            set: fn ($newValue) => serialize(array_unique(Arr::wrap($newValue), SORT_STRING))
        );
    }

    public function rank(): Attribute
    {
        return Attribute::set(fn ($value) => $value <= 5.0 ? floatval($value) : null);
    }

    public function scopeSeen(Builder $query, bool $seen = false)
    {
        $query->where('seen', $seen);
    }

    public function scopeFromCustomer(Builder $query)
    {
        $query->whereIn(
            'user_id',
            User::where('role', 'customer')->get()->pluck('id')
        );
    }

    public function responses()
    {
        return $this->messages();
    }
}
