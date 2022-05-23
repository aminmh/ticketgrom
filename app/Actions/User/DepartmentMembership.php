<?php

namespace App\Actions\User;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DepartmentMembership
{

    public function __construct(
        private Request $request
    ) {
    }

    public function syncMembership(Department $department, ?int $userId = null, bool $detach = false)
    {
        $request = $this->request;

        if (is_null($userId)) {
            if (!$request->has('users'))
                throw new BadRequestHttpException();
            $userIds = $request->input('users');
        }

        else $userIds = Arr::wrap($userId);

        $department->members()->sync($userIds, $detach);
    }

    public function exclusion(Department $department)
    {
    }
}
