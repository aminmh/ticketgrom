<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Infrastructure\Contracts\Repository\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements RepositoryInterface
{

    public function __construct(
        protected Model $model
    ) {
    }

    public function find(int|array $id)
    {
        return $this->model->find($id);
    }

    public function all()
    {
        return $this->model->all();
    }
}
