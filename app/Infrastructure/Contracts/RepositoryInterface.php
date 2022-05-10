<?php

namespace App\Infrastructure\Contracts;

interface RepositoryInterface
{

    public function find(int|array $id);

    public function all();
}
