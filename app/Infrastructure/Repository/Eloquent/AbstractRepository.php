<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Infrastructure\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements RepositoryInterface
{

    public function __construct(
        protected Model $model
    ) {
    }

    public function find(int|array $id)
    {
        if (is_array($id))
            return $this->model->findMany($id);

        return $this->model->find($id);
    }

    public function all()
    {
        return $this->model->all();
    }
}
