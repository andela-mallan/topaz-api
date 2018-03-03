<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Routes for authentication
 */
Route::prefix('api/v1/')->group(function () {
    Route::post('register', 'RegisterController@register');
    Route::post('login', 'LoginController@login');
    Route::post('recover', 'ResetPasswordController@recover');
    Route::post('logout', 'LoginController@logout')->middleware('jwt.auth');
});

/**
 * Routes for password reset
 */
// Route::prefix('api/v1/password')->group(function () {
//     Route::get('/reset/{token?}', 'Auth\PasswordController@showResetForm');
//     Route::post('/reset', 'Auth\PasswordController@reset');
// });

/**
 * Routes for members
 */
Route::prefix('api/v1/')->group(function () {
    Route::get('members', 'MembersController@all');
    Route::get('member/{id}', 'MembersController@getMemberById')
      ->where(['id' => '[0-9]+']);
    Route::get('member/{name}', 'MembersController@getMemberByName')
      ->where(['name' => '[A-Za-z]+']);
    Route::post('member/register', 'MembersController@createMember');
    Route::patch('member/{id}/edit', 'MembersController@editMember');
    Route::delete('member/{id}', 'MembersController@deleteMember');
});

/**
 * Routes for contributions
 */
Route::prefix('api/v1/')->group(function () {
    Route::get('contributions', 'ContributionsController@all');
    Route::get('contribution/{member_id}', 'ContributionsController@getContributionsByMemberId')
      ->where(['member_id' => '[0-9]+']);
    Route::get('contribution/{name}', 'ContributionsController@getContributionsByMemberName')
      ->where(['name' => '[A-Za-z]+']);
    Route::post('contribution', 'ContributionsController@logMonthlyContribution');
    Route::patch('contribution/{id}/edit', 'ContributionsController@editMonthlyContribution');
    Route::patch('contribution/confirm', 'ContributionsController@confirmContribution')
      ->middleware('auth:admin');
    Route::delete('contribution/{id}', 'ContributionsController@deleteMonthlyContribution');
});

/**
* Routes for meetings
*/
Route::prefix('api/v1/')->group(function () {
    Route::get('meetings', 'MeetingsController@all');
    Route::get('meeting/{id}', 'MeetingsController@getMeetingById')
      ->where(['id' => '[0-9]+']);
    Route::post('meeting', 'MeetingsController@createMeeting');
    Route::patch('meeting/{id}/edit', 'MeetingsController@editMonthlyMeeting');
    Route::delete('meeting/{id}', 'MeetingsController@deleteMonthlyMeeting');
});

/**
 * Routes for investments
 */
 Route::prefix('api/v1/')->group(function () {
     Route::get('investments', 'InvestmentsController@all');
     Route::get('investment/{id}', 'InvestmentsController@getInvestmentById')
       ->where(['id' => '[0-9]+']);
     Route::post('investment', 'InvestmentsController@createInvestment');
     Route::patch('investment/{id}/edit', 'InvestmentsController@editInvestment');
     Route::delete('investment/{id}', 'InvestmentsController@deleteInvestment');
 });

/**
* Routes for topaz details
*/

// Route::get('/', function () {
//     return view('welcome');
// });
//
// Route::get('/home/{id}/{name}', function ($id, $name) {
//     return "Home number " . $id . " is called " . $name;
// })->where(['id' => '[0-9]+', 'name' => '[a-z]+']);

// Auth::routes();
//
// Route::get('/home', 'HomeController@index')->name('home');
