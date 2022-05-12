<?php

namespace App\Repositories\Cacheable\Eloquent;

use App\Infrastructure\Contracts\Repository\DepartmentRepositoryInterface;
use App\Infrastructure\Contracts\Repository\ObservableRepository;
use App\Infrastructure\Repository\Eloquent\AbstractCacheRepository as CacheRepository;
use App\Repositories\DB\Eloquent\DepartmentRepository;

class DepartmentCacheableRepository extends CacheRepository
implements DepartmentRepositoryInterface, ObservableRepository
{

    protected const TTL = 3600;

    protected const KEY = 'departments';

    public function __construct(
        DepartmentRepository $repository
    ) {
        parent::__construct($repository);
    }

    public function all()
    {
        return $this->cached->remember(
            key: self::KEY,
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

    public function refresh()
    {
        $this->cached->forget(self::KEY);
    }

    public function created()
    {
        $this->refresh();
    }

    public function deleted()
    {
        $this->refresh();
    }

    public function updated()
    {
        $this->refresh();
    }

    public function observe()
    {
        \App\Models\Department::observe($this);
    }
}
