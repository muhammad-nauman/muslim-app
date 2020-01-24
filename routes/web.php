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

Route::get('/', function () {
    return view('questions.add');
});

Auth::routes();

Route::middleware(['auth'])->group(function() {
    Route::get('dashboard', 'DashboardController@index');

    Route::resources([
        'categories' => 'CategoriesController',
        'questions' => 'QuestionsController',
    ]);

    // questions
    Route::get('questions', 'QuestionsController@index');
    Route::get('questions/add', 'QuestionsController@create');
    Route::get('questions/{id}/edit', 'QuestionsController@edit');
    // Users
    // Route::get('questions', 'QuestionsController@index');
    // Route::get('questions/add', 'QuestionsController@create');
    // Route::get('questions/{id}/edit', 'QuestionsController@edit');
});