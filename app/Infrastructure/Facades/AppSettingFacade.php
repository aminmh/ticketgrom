<?php

namespace App\Infrastructure\Facades;

use Illuminate\Support\Facades\Facade;
use App\Repositories\{TicketNotificationSetting, TicketEvents};
use App\Models\User;

/**
 * @method static int maxAuthenticateRateLimiter()
 * @method static int maxFileUploadSize()
 * @method static int maxTimeOutTicketResponse()
 * @method static int maxTimeOutTicketResponse()
 * @method static array allowedFileTypeUpload()
 *
 * @see \App\Repositories\DB\Eloquent\AppSettingRepository
 */
class AppSettingFacade extends Facade
{

    public static function getFacadeAccessor()
    {
        return "app_setting";
    }
}
