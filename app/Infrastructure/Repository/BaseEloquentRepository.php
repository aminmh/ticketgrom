<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Contracts\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseEloquentRepository implements EloquentRepositoryInterface
{

    public function __construct(protected Builder|Model $model)
    {
    }

    public function find(int|array $ids)
    {
        return is_array($ids) ? $this->model->findMany($ids)
            : $this->model->find($ids);
    }

    public function where(string $column, $operator = null, $value = null)
    {
        if (func_num_args() === 2)
            return $this->model->where($column, '=', func_get_args()[1]);

        return $this->model->where($column, $operator, $value);
    }
}
