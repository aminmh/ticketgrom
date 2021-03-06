<?php

namespace App\Infrastructure\Contracts\Repository;

interface SettingRepositoryInterface
{

    public function maxFileUploadSize(): int;

    public function allowedFileTypeUpload(): array;

    public function maxTimeOutTicketResponse();

    public function maxAuthenticateRateLimiter();
}
