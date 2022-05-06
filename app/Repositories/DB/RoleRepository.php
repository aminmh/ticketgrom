<?php

namespace App\Repositories\DB;

use App\Infrastructure\Repository\BaseEloquentRepository;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseEloquentRepository
{

    public function __construct(Role $role)
    {
        parent::__construct($role->newQuery());
    }

    public function findByName(string $name)
    {
        return $this->where('name', $name);
    }
}
