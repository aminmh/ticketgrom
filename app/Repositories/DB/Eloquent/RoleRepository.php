<?php

namespace App\Repositories\DB\Eloquent;

use App\Infrastructure\Repository\Eloquent\AbstractRepository as Repository;
use Spatie\Permission\Models\Role;

class RoleRepository extends Repository
{

    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    public function findByName(string $name)
    {
        return $this->model->where('name', $name);
    }
}
