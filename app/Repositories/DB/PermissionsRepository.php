<?php

namespace App\Repositories\DB;

use App\Infrastructure\Repository\BaseEloquentRepository;
use Spatie\Permission\Models\Permission;

class PermissionsRepository extends BaseEloquentRepository
{

    public function __construct(protected Permission $permission)
    {
        parent::__construct($permission->newQuery());
    }

    public function findMany(array $ids)
    {
        return $this->model->findMany($ids);
    }
}
