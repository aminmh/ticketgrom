<?php

namespace App\Providers;

use Illuminate\Support\Collection;
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
        $this->bindCacheableRepositories();

        $this->bindRepositories();
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

    public function provides(): Collection
    {
        return collect([
            "cacheable" => config('repository.cache'),
            "db" => config('repository.db')
        ]);
    }

    private function bindCacheableRepositories()
    {
        foreach ($this->provides()->get('cacheable') as $abstract => $concrete)
            $this->app
                ->singleton($abstract, $concrete);
    }

    private function bindRepositories()
    {
        foreach ($this->provides()->get('db') as $abstract => $concrete)
            $this->app->bind($abstract, $concrete);
    }
}
