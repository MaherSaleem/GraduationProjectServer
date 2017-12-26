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

        $query = $questionText;
        $file = SubmissionController::generateRandomString() . '.txt';
        $command = 'java -jar ' . public_path('jars/nn.jar') . " \"$query\" $file";
        system($command);
        $file_handle = fopen($file, "r");
        $jsonData = fgets($file_handle);
        $dataOfJson = json_decode($jsonData, true);
        $answers = $dataOfJson['answers'];
        $query = $dataOfJson['query'];
        $submission = Submission::create(compact('query'));
        $submissionId = $submission->id;

        $i = 1;
        foreach ($answers as $answer) {
            $submission->answers()->create(['text' => $answer, 'rank' => $i++]);
        }
        fclose($file_handle);
//        unlink($file);//delete file
        return view('answers', compact('answers', 'questionText', 'submissionId'));
    }

    public function update(Request $request, Submission $submission)
    {
        $requestData = $request->all();
        $submission->rank = $requestData['rank'];
        $submission->save();
        return view('thanks');

    }

    static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}

