<?php

namespace App\Models;

use App\Infrastructure\Traits\HasMessage;
use Database\Factories\CompanyFactory;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{

    use HasMessage, Notifiable, HasFactory;

    protected $table = 'companies';

    protected $fillable = ['name', 'website', 'address', 'banned', 'phone', 'description'];

    public $timestamps = false;

    public function customers()
    {
        return $this->hasMany(User::class, 'company_id', 'id');
    }

    protected static function newFactory()
    {
        return CompanyFactory::new();
    }
}
