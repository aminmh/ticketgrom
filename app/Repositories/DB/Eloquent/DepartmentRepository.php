<?php

namespace App\Repositories\DB\Eloquent;

use App\Infrastructure\Contracts\Repository\DepartmentRepositoryInterface;
use App\Infrastructure\Repository\Eloquent\AbstractRepository as Repository;

class DepartmentRepository extends Repository implements DepartmentRepositoryInterface
{

    public function __construct(
        \App\Models\Department $department
    ) {
        parent::__construct($department);
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email);
    }

    public function members(int $id)
    {
        return $this->find($id)->members();
    }
}
