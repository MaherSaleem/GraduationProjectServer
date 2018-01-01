<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Rank;
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
        $questionText = $request->get("query");

        $json = "{ \"answers\":[
  \"زياد\",
  \"ماهر\"
  ],
  \"submissionId\":1,
  \"questionText\":\"السكري\"
}

";
        return $json;
        //write query to file
        $query = $questionText;
        $submission = Submission::create([$questionText]);
        $file = "Submission_" . $submission->id;
        $file_handle = fopen($file, "w");
        fwrite($file_handle, $query);
        fclose($file_handle);


        chmod($file, 0777);
        $command = 'java -jar -Dfile.encoding=UTF8 ' . public_path('jars/1.jar') . " \"$query\" $file";
        exec($command);
        $javaOutputFileName = $file . '.out';
        chmod($javaOutputFileName, 0777);
        //reading output from java code
        $file_handle = fopen($javaOutputFileName, "r");
        $jsonData = fread($file_handle, filesize($javaOutputFileName));
        logger($jsonData);
        $dataOfJson = json_decode(preg_replace('/[\r\n]+/', '<br>', $jsonData), true);
        $answers = $dataOfJson['answers'];
        $query = $dataOfJson['query'];
        $submissionId = $submission->id;
        $dataOfJson['submissionId'] = $submissionId;

        $i = 1;
        foreach ($answers as $answer) {
            $submission->answers()->create(['text' => $answer, 'rank' => $i++]);
        }
        $dataOfJson['answers'][-2]="لا شيء مما ذكر.";
        fclose($file_handle);
        unlink($file);//delete file
        unlink($javaOutputFileName);//delete file
        if(!$request->ajax()){
            return view('answers', compact('answers', 'questionText', 'submissionId'));
        }else{
            return $dataOfJson;
        }
    }

    public function update(Request $request, Submission $submission)
    {
        $requestData = $request->all();

        //TODO fix this in case of None option
        if (array_key_exists('rank', $requestData)) {
            $ranks = $requestData['rank'];

            //remove None option in case it was chosen with other options
            if (($minusOneindex = array_search('-1', $ranks)) !== false) {
                unset($ranks[$minusOneindex]);
            }

            if (sizeof($ranks) == 0) {// -1
                $submission->ranks()->create(['rank' => -1]);
                $submission->best_rank = -1;
            } else {
                foreach ($ranks as $rank) {
                    $submission->ranks()->create(['rank' => $rank]);
                }
                $submission->best_rank = min($ranks);

            }


            $submission->avg_correct_answers = sizeof($ranks) / $submission->answers()->count();
        } else {
            $submission->rank = -1;//to option chosen //TODO check if this is a good behaviour
            $submission->avg_correct_answers = 0;
        }

        $submission->save();
        return redirect('/submissions/thanks');

    }

    public function thanks()
    {
        return view('thanks');
    }

    public function results()
    {
        $numberOfSubmissions = Submission::hasRank()->count();
        $sum = Submission::hasRank()->where('best_rank', '>', '-1')->selectRaw('sum(1/best_rank) as sum')->first()->sum;
        $answerExist = Submission::hasRank()->where('best_rank', '>', '-1')->count();
        $MRR = 100 * $sum / $numberOfSubmissions;
        $answerExistPercent = 100 * $answerExist / $numberOfSubmissions;

        $avgAnswersPerQuestion = 100 * Submission::sum('avg_correct_answers') / $numberOfSubmissions;
        return view('results', compact('MRR', 'answerExistPercent', 'numberOfSubmissions', 'avgAnswersPerQuestion'));

    }


    static function generateRandomString()
    {
        return date('YmdHi');
    }


}

