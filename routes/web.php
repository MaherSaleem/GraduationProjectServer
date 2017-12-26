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


Route::get('/questions', 'QuestionController@allQuestions');
Route::post('/questions', 'QuestionController@storeQuestion');
Route::get('/questions/{question}', 'QuestionController@getQuestion');

Route::get('/forms', 'FormController@allForms');
Route::get('/forms/{form}', 'FormController@getForm');
Route::post('/forms/{question}', 'FormController@storeForm'); //store new form for a given question_id (need text as param)
Route::get('/forms/document/{form}', 'FormController@getDocuments');//get documents for a given form (need form_id)
Route::get('/forms/documentRank/{form}', 'FormController@getDocumentsForRank');//get documents for a given form (need form_id)


Route::get('/documents', 'DocumentController@allDocuments');
Route::get('/documents/{document}', 'DocumentController@getDocument');

//insert document to a given form_id (need text and link as params)
Route::post('/forms/document/{form}', 'DocumentController@saveDocument');



Route::get('/submissions/create', 'SubmissionController@create');
Route::post('/submissions/store', 'SubmissionController@store');
Route::put('/submissions/{submission}', 'SubmissionController@update');

Route::get('/results', function () {
    $numberOfSubmissions = \App\Submission::hasRank()->count();

    $sum = \App\Submission::hasRank()->where('rank', '>', '-1')->selectRaw('sum(1/rank) as sum')->first()->sum;
    $MRR = $sum/$numberOfSubmissions;

    return view('results', compact('MRR'));

});

