<?php

namespace App\Http\Controllers;

use App\Question;
use App\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{


    public function create()
    {
        return view('submission_show');
    }

    public function store(Request $request)
    {
        //TODO excute java code to get json data
        $questionText = $request->get("query");
        $jsonData = '{"answers":["ماهر", "سليم", "اخضير"],"query": "ما هي اعراض مرض السكري"}';

        $data = json_decode($jsonData, true);
        $answers = $data['answers'];
        $query = $data['query'];
        $submission = Submission::create(compact('query'));
        $submissionId = $submission->id;
        foreach ($answers as $answer) {
            $submission->answers()->create(['text' => $answer]);
        }
        return view('answers', compact('answers', 'questionText', 'submissionId'));
    }

    public function update(Request $request, Submission $submission){
        $requestData = $request->all();
        $submission->rank = $requestData['rank'];
        $submission->save();
        return view('thanks');

    }

}

