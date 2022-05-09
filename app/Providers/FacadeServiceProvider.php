<?php

namespace App\Providers;

use App\Infrastructure\Contracts\SmsSenderInterface;
use App\Services\MeliPayamak;
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
        $this->app->bind('sms', $this->resolveProvider());

        $this->app->alias($this->resolveProvider(), SmsSenderInterface::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    private function resolveProvider()
    {
        return match (config('sms.default')) {
            'melipayamak' => \App\Services\MeliPayamak::class,
        };
    }
}
