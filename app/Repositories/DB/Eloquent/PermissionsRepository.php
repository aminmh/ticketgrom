<?php

namespace App\Repositories\DB\Eloquent;

use App\Infrastructure\Repository\Eloquent\AbstractRepository as Repository;
use Spatie\Permission\Models\Permission;

class PermissionsRepository extends Repository
{

    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
    }
}
