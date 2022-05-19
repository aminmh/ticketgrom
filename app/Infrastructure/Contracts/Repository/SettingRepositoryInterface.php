<?php

namespace App\Infrastructure\Contracts\Repository;

use App\Repositories\{TicketNotificationSetting, TicketEvents};

interface SettingRepositoryInterface
{

    public function maxFileUploadSize(): int;

    public function allowedFileTypeUpload(): array;

    public function ticketNotifications(TicketEvents $event, TicketNotificationSetting $key, ?\App\Models\User $for);

    public function maxTimeOutTicketResponse();

    public function maxAuthenticateRateLimiter();
}
