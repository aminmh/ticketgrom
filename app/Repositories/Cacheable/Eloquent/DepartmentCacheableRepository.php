<?php

namespace App\Repositories\Cacheable\Eloquent;

use App\Infrastructure\Contracts\Repository\DepartmentRepositoryInterface;
use App\Repositories\DB\Eloquent\DepartmentRepository;

class DepartmentCacheableRepository implements DepartmentRepositoryInterface
{

    protected const TTL = 3600;

    public function __construct(
        protected DepartmentRepository $repository,
        protected \Illuminate\Cache\Repository $cached
    ) {
    }

    public function all()
    {
        return $this->cached->remember(
            key: 'departments',
            ttl: self::TTL,
            callback: fn () =>
            $this->repository->all()
        );
    }

    public function find(int|array $id)
    {
        return $this->all()->find($id);
    }

    public function members(int $id)
    {
        return $this->find($id)->members();
    }

    public function findByEmail(string $email)
    {
        return $this->all()->where('email', $email)->first();
    }
}
