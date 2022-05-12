<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Infrastructure\Contracts\Repository\RepositoryInterface;

abstract class AbstractCacheRepository
{

    protected \Illuminate\Cache\Repository $cached;

    public function __construct(
        protected RepositoryInterface $repository,
    ) {
        $this->cached = app(\Illuminate\Cache\Repository::class);

        $this->observe();
    }

    abstract public function refresh();

    abstract public function observe();
}
