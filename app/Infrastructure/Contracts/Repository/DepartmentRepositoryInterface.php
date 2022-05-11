<?php

namespace App\Infrastructure\Contracts\Repository;

interface DepartmentRepositoryInterface extends RepositoryInterface
{

    public function members(int $id);

    public function findByEmail(string $email);
}
