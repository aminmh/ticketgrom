<?php

namespace Modules\Setting\Contracts;

use Modules\Setting\Repository\SettingRepository;

interface SettingRepositoryInterface
{
    public function forUser(int|\App\Models\User $user): SettingRepository;


    public function getUserSetting();


    public function ticketSetting(\Modules\Setting\Enums\TicketSetting $key);


    public function messageSetting(string $key = "message");

    public function appSetting(\Modules\Setting\Enums\TicketSetting $key);
}
