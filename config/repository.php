<?php

use App\Infrastructure\Contracts\Repository\DepartmentRepositoryInterface;
use App\Repositories\Cacheable\Eloquent\DepartmentCacheableRepository;

return [

    'db' => [],

    'cache' => [
        DepartmentRepositoryInterface::class => DepartmentCacheableRepository::class
    ]
];
