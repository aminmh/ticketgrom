<?php

namespace App\Providers;

use App\Infrastructure\Contracts\SmsSenderInterface;
use App\Repositories\DB\Eloquent\AppSettingRepository;
use Illuminate\Support\ServiceProvider;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('sms', $this->smsProvider());

        $this->app->bind("app_setting", AppSettingRepository::class);

        $this->app->alias($this->smsProvider(), SmsSenderInterface::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    private function smsProvider()
    {
        $defaultProvider = config('sms.default');

        return data_get(config('sms.providers')[$defaultProvider], 'service');
    }
}
