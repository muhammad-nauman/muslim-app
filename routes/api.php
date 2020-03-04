<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(
    [
        'quizzes' => 'Api\QuizController',
        'questions' => 'Api\QuestionsController',
        'contents' => 'Api\ContentController',
        'weekly_reminders' => 'Api\WeeklyRemindersController',
        'devices' => 'Api\DevicesController',
        'categories' => 'Api\CategoriesController',
        'headings' => 'Api\HeadingsController',
    ]
);

Route::get('question_categories', 'Api\QuestionCategoryController');
Route::post('like/content/{content}', 'Api\ContentController@like');
Route::post('like/reminder/{weeklyReminder}', 'Api\WeeklyRemindersController@like');
