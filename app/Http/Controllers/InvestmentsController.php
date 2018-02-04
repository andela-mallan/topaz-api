<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
          'expected_investment_value' => json_encode(
              explode(',', $request->input('expected_investment_value')),
              JSON_NUMERIC_CHECK
          )
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
        $updateInvestment = [];
        if ($request->input('in_progress')) {
            $in_progress = ['in_progress' => $request->input('in_progress')];
            $updateInvestment = array_merge($updateInvestment, $in_progress);
        } elseif ($request->input('expected_investment_value')) {
            $expected_investment_value = ['expected_investment_value' => json_encode(explode(',', $request->input('expected_investment_value')), JSON_NUMERIC_CHECK)];
            $updateInvestment = array_merge($updateInvestment, $expected_investment_value);
        } elseif ($request->input('total_investment_value')) {
            $total_investment_value = ['total_investment_value' => json_encode(explode(',', $request->input('total_investment_value')), JSON_NUMERIC_CHECK)];
            $updateInvestment = array_merge($updateInvestment, $total_investment_value);
        } elseif ($request->input('revenue')) {
            $revenue = ['revenue' => json_encode(explode(',', $request->input('revenue')), JSON_NUMERIC_CHECK)];
            $updateInvestment = array_merge($updateInvestment, $revenue);
        } elseif ($request->input('profits')) {
            $profits = ['profits' => json_encode(explode(',', $request->input('profits')), JSON_NUMERIC_CHECK)];
            $updateInvestment = array_merge($updateInvestment, $profits);
        }
        $updatedInvestment = Investment::updateOrCreate(['id' => $id], $updateInvestment);
        $response = ["data" => $updatedInvestment];

        return response($response, Response::HTTP_OK);
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
