<?php

namespace App\Actions\User;

use App\Models\User;
use App\Repositories\DB\PermissionsRepository;
use App\Repositories\DB\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Role;

class AccessControl
{

    public function __construct(
        protected Request $request,
        protected RoleRepository $roleRepository,
        protected PermissionsRepository $permissionsRepository
    ) {
    }

    public function createRole()
    {
        Role::create([
            'name' => $this->request->input('name')
        ]);
    }

    public function grantPermissionToRole(Role $role, bool $sync = false)
    {
        $permissions = $this->permissionsRepository->findMany($this->request->input('permissions.*'));

        $sync ? $role->syncPermissions($permissions)
            : $role->givePermissionTo($permissions);
    }

    public function grantRoleToUser(User $user, bool $sync = false)
    {
        $roles = $this->roleRepository->find($this->request->input('roles.*'));

        $sync ?
            $user->syncRoles($roles) : $user->assignRole($roles);
    }

    public function dropUserRoles(User $user)
    {
        $user->roles()->detach($this->request->input('roles.*'));
    }
}
