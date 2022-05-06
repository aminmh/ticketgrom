<?php

namespace App\Infrastructure\Contracts;

interface DepartmentRepositoryInterface {

    public function findByName(string $name);
}
