<?php

use App\Infrastructure\Contracts\Repository\{
    DepartmentRepositoryInterface,
    UserRepositoryInterface
};
use App\Repositories\Cacheable\Eloquent\DepartmentCacheableRepository;
use App\Repositories\DB\Eloquent\UserRepository;

return [

    'db' => [
        UserRepositoryInterface::class => UserRepository::class
    ],

    'cache' => [
        DepartmentRepositoryInterface::class => DepartmentCacheableRepository::class
    ]
];
