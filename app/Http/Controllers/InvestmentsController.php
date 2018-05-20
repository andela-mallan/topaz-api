<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Investment;

class InvestmentsController extends Controller
{
    /**
     * Protect the routes that use this controller
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Get all investments
     *
     * @return object - investments objects
     */
    public function all()
    {
        $investments = Investment::get();
        $response = ["data" => $investments];

        return response($response, Response::HTTP_OK);
    }

    /**
     * Get investment by id
     *
     * @param Integer $investment_id - id of the investment
     * @return object - investment object
     */
    public function getInvestmentById($id)
    {
        try {
            $investment = Investment::findOrFail($id);
            $response = ["data" => $investment];

            return response($response, Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException('Investment with id ' .$id. ' does not exist');
            return response('404 Error Occured', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Create an investment
     *
     * @param Request|object $request - request payload
     * @return object - investment object
     */
    public function createInvestment(Request $request)
    {
        $newInvestmentInfo = [
          'project_name' => $request->input('project_name'),
          'description' => $request->input('description'),
          'location' => $request->input('location'),
          'start_date' => $request->input('start_date'),
          'in_progress' => $request->input('in_progress'),
          'expected_investment_value' => json_encode(json_decode($request->input('expected_investment_value'), true)),
          'total_investment_value' => json_encode(json_decode($request->input('total_investment_value'), true)),
          'revenue' => json_encode(json_decode($request->input('revenue'), true)),
          'profits' => json_encode(json_decode($request->input('profits'), true))
        ];
        $newInvestment = Investment::firstOrCreate($newInvestmentInfo);
        $response = ["data" => $newInvestment];

        return response($response, Response::HTTP_CREATED);
    }

    /**
     * Update an investment's details
     *
     * @param Integer $id - id of the investment to update
     * @return object - updated investment object
     */
    public function editInvestment(Request $request, $id)
    {
        try {
            $investment = Investment::findOrFail($id);

            $updateInvestmentInfo = [
              'project_name' => $request->has('project_name') ?
                  $request->input('project_name') : $investment->project_name,
              'description' => $request->has('description') ?
                  $request->input('description') : $investment->description,
              'location' => $request->has('location') ?
                  $request->input('location') : $investment->location,
              'start_date' => $request->has('start_date') ?
                  $request->input('start_date') : $investment->start_date,
              'in_progress' => $request->has('in_progress') ?
                  $request->input('in_progress') : $investment->in_progress,
              'expected_investment_value' => $request->has('expected_investment_value') ?
                  json_encode(json_decode($request->input('expected_investment_value'), true)) :
                  $investment->expected_investment_value,
              'total_investment_value' => $request->has('total_investment_value') ?
                  json_encode(json_decode($request->input('total_investment_value'), true)) :
                  $investment->total_investment_value,
              'revenue' => $request->has('revenue') ?
                  json_encode(json_decode($request->input('revenue'), true)) : $investment->revenue,
              'profits' => $request->has('profits') ?
                  json_encode(json_decode($request->input('profits'), true)) : $investment->profits
            ];

            $updatedInvestment = Investment::updateOrCreate(['id' => $id], $updateInvestmentInfo);
            $response = ["data" => $updatedInvestment];

            return response($response, Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException('Investment with id ' .$id. ' does not exist');
            return response('404 Error Occured', Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Delete an existing investment
     *
     * @param Integer $id - id of the investment to delete
     * @return Boolean - whether successfully deleted or not
     */
    public function deleteInvestment(Request $request, $id)
    {
        try {
            $deleteInvestment = Investment::findOrFail($id)->delete();
            $response = ["data" => $deleteInvestment];

            return response($response, Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException('Investment with id ' .$id. ' does not exist');
            return response('404 Error Occured', Response::HTTP_BAD_REQUEST);
        }
    }
}
