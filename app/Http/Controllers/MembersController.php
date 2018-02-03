<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;

use App\Member;

class MembersController extends Controller
{
    /**
     * Get all topaz members
     *
     * @return object - member objects
     */
    public function all()
    {
        $members = Member::get();
        $response = ["data" => $members];

        return response($response, Response::HTTP_OK);
    }

    /**
     * Get topaz members by id
     *
     * @param Integer $id - id of the member
     * @return object - member object that matches the id
     * @throws NotFoundException
     */
    public function getMemberById($id)
    {
        try {
            $member = Member::findorFail($id);
            $response = ["data" => $member];

            return response($response, Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException('Member with id ' .$id. ' does not exist');
            return response('404 Error Occured', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Get topaz members by name
     *
     * @param String $name - name of member
     * @return object - member object that matches the name
     */
    public function getMemberByName($name)
    {
        $member = Member::where('name', 'LIKE', '%'.$name.'%')->get();
        $response = ["data" => $member];

        return response($response, Response::HTTP_OK);
    }

    /**
     * Register new topaz member
     *
     * @param Request|object $request - request payload
     * @return object - member object for registered member
     */
    public function createMember(Request $request)
    {
        $newMemberData = [
          'name' => $request->input('name'),
          'role' => $request->input('role'),
          'role_description' => $request->input('role_description'),
          'email' => $request->input('email'),
          'phone' => $request->input('phone'),
          'photo' => $request->input('photo')
        ];
        $newMember = Member::firstOrCreate($newMemberData);
        $response = ["data" => $newMember];

        return response($response, Response::HTTP_CREATED);
    }

    /**
     * Update member model in database
     *
     * @param Integer $id - id of the member whose data is to edited
     * @return object - member object for updated member
     */
    public function editMember($id)
    {
        try {
            $updateMember = Member::findorFail($id)->fill(Input::all());
            $updateMember->update();
            $response = ["data" => $updateMember];

            return response($response, Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException('Member with id ' .$id. ' does not exist');
            return response('404 Error Occured', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Delete member model from database
     *
     * @param Integer $id - id of the member whose obj is to be deleted
     * @return bool|int
     */
    public function deleteMember($id)
    {
        try {
            $deleteMember = Member::findorFail($id)->delete();
            $response = ["data" => $deleteMember];

            return response($response, Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException('Member with id ' .$id. ' does not exist');
            return response('404 Error Occured', Response::HTTP_BAD_REQUEST);
        }
    }
}
