<?php

namespace App\Repositories\DB\Eloquent;

use App\Infrastructure\Contracts\Repository\SettingRepositoryInterface;
use App\Infrastructure\Repository\Eloquent\AbstractRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class AppSettingRepository implements SettingRepositoryInterface
{
    private Collection $setting;

    public function __construct(\App\Models\Setting $model)
    {;
        $this->setting = collect(
            $model
                ->where('scope', 'app_setting')
                ->first()->setting
        );
    }

    public function maxAuthenticateRateLimiter()
    {
        return $this->setting->get('max_authenticate_limit');
    }

    public function maxFileUploadSize(): int
    {
        return (int)$this->setting->get("max_file_upload_size");
    }

    public function maxTimeOutTicketResponse()
    {
        return $this->setting->get('max_timeout_response_to_ticket');
    }

    public function ticketNotifications(string $key)
    {
        $notifications = data_get($this->setting->get('notifications'), 'ticket');

        if ($this->user()->hasRole(['superuser', 'admin']))
            return data_get($notifications, "superuser.$key");

        return data_get($notifications, "user.$key");
    }

    public function allowedFileTypeUpload(): array
    {
        return Arr::wrap($this->setting->get('file_types_allowed'));
    }

    private function user(): \App\Models\User
    {
        return auth()->user() ?? \App\Models\User::find(1);
    }
}
