<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

use App\Contribution;

class ContributionsController extends Controller
{
    /**
     * Protect the routes that use this controller
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Get all contributions with their related members
     *
     * @return object - contribution objects with member relationships
     */
    public function all()
    {
        $contributions = Contribution::with('member')->get();
        $response = ["data" => $contributions];

        return response($response, Response::HTTP_OK);
    }

    /**
     * Get contributions for members by id
     *
     * @param Integer $member_id - member_id of the member
     * @return object - contribution object(s) for particular member
     */
    public function getContributionsByMemberId($member_id)
    {
        $memberContributions = Contribution::with('member')
          ->where('member_id', $member_id)
          ->get();
        $response = ["data" => $memberContributions];

        return response($response, Response::HTTP_OK);
    }

    /**
     * Get contributions for members by their name
     *
     * @param String $name - name of member
     * @return object - contribution object(s) for particular member
     */
    public function getContributionsByMemberName($name)
    {
        $memberContributions = Contribution::whereHas('member', function ($query) use ($name) {
            $query->where('name', 'LIKE', '%'.$name.'%');
        })->get();
        $response = ["data" => $memberContributions];

        return response($response, Response::HTTP_OK);
    }

    /** Will have to change the member_id here to use the Auth::id() or $request->userid **
     * Log members month's contribution
     *
     * @param Request|object $request - request payload
     * @return object - contribution object
     */
    public function logMonthlyContribution(Request $request)
    {
        $newContributionData = [
          'member_id' => $request->input('member_id'),
          'month_contribution' => $request->input('month_contribution'),
          'month_fine' => $request->input('month_fine'),
          'time_paid' => $request->input('time_paid'),
          'receipt' => $request->input('receipt')
        ];
        $newContribution = Contribution::firstOrCreate($newContributionData);
        $response = ["data" => $newContribution];

        return response($response, Response::HTTP_CREATED);
    }

    /**
     * Update month's contribution in database
     *
     * @param Integer $id - id of the contribution to update
     * @return object - updated contribution object
     */
    public function editMonthlyContribution($id)
    {
        try {
            $updateContribution = Contribution::findorFail($id)->fill(Input::all());
            $updateContribution->update();
            $response = ["data" => $updateContribution];

            return response($response, Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException('Contribution with id ' .$id. ' does not exist');
            return response('404 Error Occured', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Delete contribution from database
     *
     * @param Integer $id - id of the contribution to delete
     * @return bool|int
     */
    public function deleteMonthlyContribution($id)
    {
        try {
            $deleteContribution = Contribution::findorFail($id)->delete();
            $response = ["data" => $deleteContribution];

            return response($response, Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException('Contribution with id ' .$id. ' does not exist');
            return response('404 Error Occured', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Admin confirms contribution made by other members
     *
     * @param
     * @return
     */
    public function verifyContribution($id)
    {
        if (Auth::user()->hasRole('admin')) {
            try {
                $verifyContribution = Contribution::findorFail($id);
                $verifyContribution->verified = true;
                $verifyContribution->save();

                return response("Verified", Response::HTTP_OK);
            } catch (ModelNotFoundException $exception) {
                throw new ModelNotFoundException('Contribution with id ' .$id. ' does not exist');
                return response('404 Error Occured', Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response('403 Forbidden', Response::HTTP_FORBIDDEN);
        }
    }
}
