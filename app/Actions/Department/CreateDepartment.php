<?php

namespace App\Actions\Department;

use App\Http\Requests\DepartmentReuqest;
use App\Infrastructure\Contracts\Repository\UserRepositoryInterface;
use App\Models\Department;

class CreateDepartment
{

    public function __construct(
        private DepartmentReuqest $request,
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function create()
    {
        $newDepartment = new Department();
        $newDepartment->name = $this->request->input('name');
        $newDepartment->save();

        return $newDepartment;
    }

    public function createFromUsers()
    {
        $newDepartment = $this->create();

        $newDepartment->members()->attach($this->request->users);
    }
}
