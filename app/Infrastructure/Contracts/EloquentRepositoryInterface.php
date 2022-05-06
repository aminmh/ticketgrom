<?php

namespace App\Infrastructure\Contracts;

interface EloquentRepositoryInterface
{

    public function find(int $id);

    public function where(string $column, ?string $operator, $value);
}
