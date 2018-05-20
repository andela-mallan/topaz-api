<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Permission;
use App\Role;

class PermissionController extends Controller
{
    /**
     * Protect the routes that use this controller
     */
    // public function __construct()
    // {
    //     $this->middleware('ability:admin');
    // }

    public function createPermission(Request $request)
    {
        $viewUsers = new Permission();
        $viewUsers->name = $request->input('name');
        $viewUsers->display_name = $request->input('display_name') ?: null;
        $viewUsers->description = $request->input('description') ?: null;
        $viewUsers->save();

        // return response()->json("created");
        return response("created", Response::HTTP_OK);
    }

    public function attachPermission(Request $request)
    {
        $role = Role::where('name', $request->input('role'))->first();
        $permission = Permission::where('name', $request->input('name'))->first();
        $role->attachPermission($permission);
        // Can also add an array of permissions to one role at once
        // $role->attachPermissions(array($createPost, $editUser));

        return response("created", Response::HTTP_OK);
    }
}
