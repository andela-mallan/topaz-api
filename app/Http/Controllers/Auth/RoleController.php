<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Role;
use App\User;

class RoleController extends Controller
{
    public function createRole(Request $request)
    {
        $role = new Role();
        $role->name = $request->input('name');
        $role->display_name = $request->input('display_name') ?: null;
        $role->description = $request->input('description') ?: null;
        $role->save();

        // return response()->json("created");
        return response("created", Response::HTTP_OK);
    }

    public function assignRole(Request $request)
    {
        $user = User::where('name', $request->input('name'))->first();
        $role = Role::where('name', $request->input('role'))->first();
        //$user->attachRole($request->input('role'));  // role attach alias. parameter can be Role object, array or id
        $user->roles()->attach($role->id);  // eloquent's original technique

        return response("created", Response::HTTP_OK);
    }
}
