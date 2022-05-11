<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        list($cache, $db) = $this->provides();

        $this->bindCacheableRepositories($cache);

        $this->bindRepositories($db);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides()
    {
        return [
            config('repository.cache'),
            config('repository.db')
        ];
    }

    private function bindCacheableRepositories(array $abstracts)
    {
        foreach ($abstracts as $abstract => $concrete)
            $this->app->singleton($abstract, $concrete);
    }

    private function bindRepositories(array $abstracts)
    {
        foreach ($abstracts as $abstract => $concrete)
            $this->app->bind($abstract, $concrete);
    }
}
