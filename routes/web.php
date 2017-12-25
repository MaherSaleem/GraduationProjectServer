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














Route::get('/questionPage', function () {
    return view('questionPage');

});

Route::post('/test', function (\Illuminate\Http\Request $request) {

    //TODO excute java code to get json data
    $questionText = $request->get("query");
    $jsonData = '{"answers":["ماهر", "سليم", "اخضير"],"query": "ما هي اعراض مرض السكري"}';

    $data = json_decode($jsonData, true);
    $answers = $data['answers'];
    $query = $data['query'];
    $submission = \App\Submission::create(compact('query'));
    $submissionId = $submission->id;

    foreach ($answers as $answer){
        $submission->answers()->create(['text' => $answer]);
    }
    return view('answers', compact('answers', 'questionText', 'submissionId'));
});

Route::post('/submit', function (\Illuminate\Http\Request $request) {
    $requestData = $request->all();
    $submissionId = $requestData['submissionId'];
    $submission = \App\Submission::find($submissionId);
    $submission->rank = $requestData['rank'];
    $submission->save();
});

Route::get('/results', function () {
    $numberOfSubmissions = \App\Submission::count();

    $sum = \App\Submission::where('rank', '>', '-1')->selectRaw('sum(1/rank) as sum')->first()->sum;
    $MRR = $sum/$numberOfSubmissions;

    return view('results', compact('MRR'));

});

