<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'setting';

    protected $fillable = ['user_id', 'setting','scope'];

    public $timestamps = false;

    protected function setting(): Attribute
    {
        return Attribute::make(
            get: fn ($setting) => json_decode($setting, true),
            set: fn ($value = []) => json_encode($value, JSON_PRETTY_PRINT)
        );
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
