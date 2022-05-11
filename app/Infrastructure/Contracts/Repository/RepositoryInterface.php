<?php

namespace App\Infrastructure\Contracts\Repository;

interface RepositoryInterface
{
    public function find(int|array $id);

    public function all();
}
