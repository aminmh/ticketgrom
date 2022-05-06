<?php

namespace App\Repositories\DB;

use App\Infrastructure\Contracts\DepartmentRepositoryInterface;
use App\Infrastructure\Repository\BaseEloquentRepository;
use App\Models\Department;

class DepartmentRepository extends BaseEloquentRepository implements DepartmentRepositoryInterface
{

    public function __construct(protected Department $department)
    {
        parent::__construct($department->newQuery());
    }

    public function findByName(string $name)
    {
        return $this->where('name', $name);
    }
}
