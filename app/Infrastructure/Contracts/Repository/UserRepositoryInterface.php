<?php

namespace App\Infrastructure\Contracts\Repository;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByEmail(string|array $email);

    public function findByRole(string $role);
}
