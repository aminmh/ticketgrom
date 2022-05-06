<?php

namespace Modules\Setting\Repository;

use App\Infrastructure\Repository\BaseEloquentRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Modules\Setting\Contracts\SettingRepositoryInterface;
use Modules\Setting\Enums\Permissions;
use Modules\Setting\Enums\TicketSetting;
use Modules\Setting\Model\Setting;
use Spatie\Permission\Exceptions\UnauthorizedException;

class SettingRepository extends BaseEloquentRepository implements SettingRepositoryInterface
{

    protected User $user;

    public function __construct(Setting $setting)
    {
        parent::__construct($setting);
    }

    public function forUser(int|User $user): self
    {

        $this->user = is_int($user) ? User::findOrFail($user) : $user;

        return $this;
    }

    public function getUserSetting()
    {
        return $this->getUser()->setting()->first()->setting;
    }

    public function getUser(): \App\Models\User
    {
        return ($this->user ?? $this->forUser(auth()->user()));
    }

    public function ticketSetting(TicketSetting $key)
    {
        return data_get($this->getUserSetting(), $key->value);
    }

    public function messageSetting(string $key = "message")
    {
        return data_get($this->getUserSetting(), $key);
    }

    public function appSetting(TicketSetting $key)
    {
        $setting = $this->forUser(
            \App\Models\User::whereHas('roles', function (Builder $query) {
                $query->where('name', 'admin');
            })->first()
        )->getUserSetting();

        return data_get($setting, $key->value);
    }
}
