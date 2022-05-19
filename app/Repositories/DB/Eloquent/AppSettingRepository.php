<?php

namespace App\Repositories\DB\Eloquent;

use App\Infrastructure\Contracts\Repository\SettingRepositoryInterface;
use App\Models\Setting;
use App\Models\User;
use App\Repositories\{TicketNotificationSetting, TicketEvents};
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class AppSettingRepository implements SettingRepositoryInterface
{
    private Collection $setting;

    private const MAX_AUTHENTICATE_LIMIT = "max_authenticate_limit";

    private const MAX_FILE_UPLOAD_SIZE = "max_file_upload_size";

    private const MAX_TIMEOUT_RESPONSE_TO_TICKET = "max_timeout_response_to_ticket";

    private const FILE_TYPES_ALLOWED = "file_types_allowed";


    public function __construct(\App\Models\Setting $model)
    {;
        $this->setting = collect(
            $model
                ->firstWhere('scope', Setting::APP_SETTING_SCOPE)->setting
        );
    }

    public function maxAuthenticateRateLimiter()
    {
        return $this->setting->get(self::MAX_AUTHENTICATE_LIMIT);
    }

    public function maxFileUploadSize(): int
    {
        return (int)$this->setting->get(self::MAX_FILE_UPLOAD_SIZE);
    }

    public function maxTimeOutTicketResponse()
    {
        return $this->setting->get(self::MAX_TIMEOUT_RESPONSE_TO_TICKET);
    }

    public function ticketNotifications(TicketEvents $event, TicketNotificationSetting $key, ?User $for = null)
    {
        $userRole = ($for ?? auth()->user())
            ->hasRole([User::ADMIN, User::SUPERUSER])
            ? User::SUPERUSER
            : User::CUSTOMER;

        $key = (string)\Illuminate\Support\Str::of("ticket.")
            ->append($event->value, ".from-$userRole.", $key->value);

        return data_get($this->setting['notifications'], $key);
    }

    public function allowedFileTypeUpload(): array
    {
        return Arr::wrap($this->setting->get(self::FILE_TYPES_ALLOWED));
    }
}
// $key = "ticket." . $event->value . ".from-$userRole." . $key->value;
