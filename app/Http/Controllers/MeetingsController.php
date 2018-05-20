<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;

use App\Meeting;

class MeetingsController extends Controller
{
    /**
     * Protect the routes that use this controller
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Get all meetings past and future
     *
     * @return object - meetings objects
     */
    public function all()
    {
        $meetings = Meeting::get();
        $response = ["data" => $meetings];

        return response($response, Response::HTTP_OK);
    }

    /**
     * Get meeting by id
     *
     * @param Integer $member_id - id of the meeting
     * @return object - meeting object
     */
    public function getMeetingById($id)
    {
        try {
            $meeting = Meeting::findOrFail($id);
            $response = ["data" => $meeting];

            return response($response, Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException('Meeting with id ' .$id. ' does not exist');
            return response('404 Error Occured', Response::HTTP_BAD_REQUEST);
        }
    }

    /** Do some data validation that the meeting selected is in the future **
     * Create a future meeting
     *
     * @param Request|object $request - request payload
     * @return object - contribution object
     */
    public function createMeeting(Request $request)
    {
        $newMeetingInfo = [
          'meeting_date' => $request->input('meeting_date'),
          'attendants' => json_encode(json_decode($request->input('attendants'))),
          'minutes' => $request->input('minutes'),
          'operation_costs' => json_encode(json_decode($request->input('operation_costs'), true)),
          'location' => $request->input('location'),
          'months_objectives' => json_encode(json_decode($request->input('months_objectives'), true))
        ];

        $newMeeting = Meeting::firstOrCreate($newMeetingInfo);
        $response = ["data" => $newMeeting];

        return response($response, Response::HTTP_CREATED);
    }

    /**
     * Update month's meetings details
     *
     * @param Integer $id - id of the meeting to update
     * @return object - updated meeting object
     */
    public function editMonthlyMeeting(Request $request, $id)
    {
        try {
            $updateMeeting = Meeting::findOrFail($id);

            $newMeetingInfo = [
              'meeting_date' => $request->has('meeting_date') ?
                  $request->input('meeting_date') : $updateMeeting->meeting_date,
              'attendants' => $request->has('attendants') ?
                  json_encode(json_decode($request->input('attendants'))) : $updateMeeting->attendants,
              'minutes' => $request->has('minutes') ?
                  $request->input('minutes') : $updateMeeting->minutes,
              'operation_costs' => $request->has('operation_costs') ?
                  json_encode(json_decode($request->input('operation_costs'), true)) : $updateMeeting->operation_costs,
              'location' => $request->has('location') ?
                  $request->input('location') : $updateMeeting->location,
              'months_objectives' => $request->has('months_objectives') ?
                  json_encode(json_decode($request->input('months_objectives'), true)) :
                  $updateMeeting->months_objectives
            ];

            $updatedMeeting = Meeting::updateOrCreate(['id' => $id], $newMeetingInfo);
            $response = ["data" => $updatedMeeting];

            return response($response, Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException('Meeting with id ' .$id. ' does not exist');
            return response('404 Error Occured', Response::HTTP_BAD_REQUEST);
        }

        $updateMeeting = [];
        if ($request->input('attendants')) {
            $attendants = ['attendants' => json_encode(explode(',', $request->input('attendants')))];
            $updateMeeting = array_merge($updateMeeting, $attendants);
        } elseif ($request->input('operation_costs')) {
            $operation_costs = ['operation_costs' => json_encode(explode(',', $request->input('operation_costs')), JSON_NUMERIC_CHECK)];
            $updateMeeting = array_merge($updateMeeting, $operation_costs);
        } elseif ($request->input('months_objectives')) {
            $months_objectives = ['months_objectives' => json_encode($request->input('months_objectives'))];
            $updateMeeting = array_merge($updateMeeting, $months_objectives);
        }
        $updatedMeeting = Meeting::updateOrCreate(['id' => $id], $updateMeeting);
        $response = ["data" => $updatedMeeting];

        return response($response, Response::HTTP_OK);
    }

    /**
     * Delete an existing past meeting
     *
     * @param Integer $id - id of the meeting to delete
     * @return Boolean - whether successfully deleted or not
     */
    public function deleteMonthlyMeeting(Request $request, $id)
    {
        try {
            $deleteMeeting = Meeting::findOrFail($id)->delete();
            $response = ["data" => $deleteMeeting];

            return response($response, Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException('Meeting with id ' .$id. ' does not exist');
            return response('404 Error Occured', Response::HTTP_BAD_REQUEST);
        }
    }
}
