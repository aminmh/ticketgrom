<?php

namespace App\Http\Controllers;

use App\Actions\Department\CreateDepartment;
use App\Actions\User\DepartmentMembership;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DepartmentController extends Controller
{

    public function store(CreateDepartment $createDepartment)
    {
        try {

            $createDepartment->create();

            return response()->json(json_message('SUCCESS'));
        } catch (\Throwable $th) {
        }
    }

    public function storeWithUsers(CreateDepartment $createDepartment)
    {
        try {

            $createDepartment->createFromUsers();
            
        } catch (\Throwable $th) {

            dd($th);
        }
    }

    public function membership(DepartmentMembership $membership, Department $department, ?User $user = null)
    {
        try {

            $membership->syncMembership($department, $user?->id);

            return response()->json(json_message('SUCCESS', ['subject' => 'عضویت در سازمان']));
        } catch (BadRequestHttpException $th) {

            dd($th);
            return response()->json(json_message('PLEASE_INTRODUCE_MEMBERSHIPS', ['subject' => 'سازمان']), 400);
        }
    }

    public function discontinueMembership(DepartmentMembership $membership, Department $department, ?User $user = null)
    {
        try {

            $membership->syncMembership($department, $user?->id, true);
        } catch (\Throwable $th) {

            dd($th);
        }
    }
}
