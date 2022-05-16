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
use Illuminate\Support\Carbon;

use function Illuminate\Events\queueable;

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
        'priority',
        'attached',
        'seen',
        'score',
        'must_close_at'
    ];

    protected $dateFormat = TIMESTAMP_FORMAT;

    protected $observables = ['responsed', 'seen'];

    protected static function booted()
    {
        static::addGlobalScope(new \App\Models\Scopes\OpenTickets);
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

    public function score(): Attribute
    {
        return Attribute::set(fn ($value) => floatval($value));
    }

    public function scopeSeen(Builder $query, bool $seen = false)
    {
        $query->where('seen', $seen);
    }

    public function scopeClosed(Builder $query)
    {
        $query->withoutGlobalScope(\App\Models\Scopes\OpenTickets::class)
            ->where('must_close_at', '<=', Carbon::now(TIMEZONE));
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

    public function makePersistent()
    {
        $this->fireModelEvent('responsed', false);
    }

    public function changedStatus()
    {
        $this->fireModelEvent('updated', false);
    }
}
