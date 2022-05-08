<?php

namespace App\Http\Controllers;

use App\Actions\User\AccessControl;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(private AccessControl $accessControl)
    {
    }

    public function signin(\App\Actions\Auth\Authentication $auth)
    {
        try {

            $user = $auth->signin();

            return response()->json([
                'data' => $user
            ]);

        } catch (\Throwable $th) {

            return response()->json(['message' => $th->getMessage()], 422);
        }
    }

    public function createRole()
    {
        try {

            $this->accessControl->createRole();

            return response()->json(json_message('SUCCESS'));
        } catch (\Throwable $th) {

            return response()->json(json_message('ERROR'), 500);
        }
    }

    public function grantPermissionToRole(\Spatie\Permission\Models\Role $role)
    {
        try {

            $this->accessControl->grantPermissionToRole($role);

            return response()->json(json_message('SUCCESS'));
        } catch (\Throwable $th) {

            return response()->json(json_message('ERROR'));
        }
    }

    public function grantRoleToUser(\App\Models\User $user)
    {
        try {

            $this->accessControl->grantRoleToUser($user);

            return response()->json(json_message('SUCCESS'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return response()->json(json_message('ERROR'));
        }
    }
}
