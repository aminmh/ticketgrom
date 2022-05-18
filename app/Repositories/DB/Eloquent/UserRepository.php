<?php

namespace App\Repositories\DB\Eloquent;

use App\Infrastructure\Contracts\Repository\UserRepositoryInterface;
use App\Infrastructure\Repository\Eloquent\AbstractRepository as Repository;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends Repository implements UserRepositoryInterface
{

    public function __construct(\App\Models\User $user)
    {
        parent::__construct($user);
    }

    public function find(int|array $id)
    {
        return $this->model->find($id);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function findByEmail(string|array $email)
    {
        if (is_string($email))
            return $this->model->where('email')->first();

        return $this->model->whereIn('email', $email)->get();
    }

    public function findByRole(string $role)
    {
        return $this->model->whereHas('roles', function (Builder $query) use ($role) {
            $query->where('name', $role);
        })->get();
    }
}
