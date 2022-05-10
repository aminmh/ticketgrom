<?php

namespace App\Repositories\DB;

use App\Infrastructure\Contracts\RepositoryInterface;
use App\Infrastructure\Repository\Eloquent\AbstractRepository as Repository;

class DepartmentRepository extends Repository
{

    public function __construct(\App\Models\Department $department)
    {
        parent::__construct($department);
    }
}
