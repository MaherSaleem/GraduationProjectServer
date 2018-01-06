<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\Rank;
use App\Submission;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

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
  \"questionText\":\"السكري\",
  \"question_type\" : \"numeric\"
}

";
//        return $json;
        //write query to file
        $query = $questionText;
        $submission = Submission::create(['query' => $questionText]);
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
//        logger($jsonData);
        $dataOfJson = json_decode(preg_replace('/[\r\n]+/', '<br>', $jsonData), true);
        $answers = $dataOfJson['answers'];
        $query = $dataOfJson['query'];
        $submissionId = $submission->id;
        $submission->question_type = $dataOfJson['question_type'];
        $submission->save();
        $dataOfJson['submissionId'] = $submissionId;

        $i = 1;
        foreach ($answers as $answer) {
            $submission->answers()->create(['text' => $answer, 'rank' => $i++]);
        }
        $dataOfJson['answers'][-2] = "لا شيء مما ذكر.";
        fclose($file_handle);
        unlink($file);//delete file
        unlink($javaOutputFileName);//delete file
        if (!$request->ajax()) {
            return view('answers', compact('answers', 'questionText', 'submissionId'));
        } else {
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
        $total = [];
        $numberOfSubmissions = Submission::hasRank()->count();
        $total['numberOfSubmissions'] = $numberOfSubmissions;
        $mrr_sum = Submission::hasRank()->where('best_rank', '>', '-1')->selectRaw('sum(1/best_rank) as sum')->first()->sum;
        $total['mrr_summation'] = $mrr_sum;
        $answerExist = Submission::hasRank()->where('best_rank', '>', '-1')->count();
        $total['answer_exists'] = $answerExist;
        $MRR = 100 * $mrr_sum / $numberOfSubmissions;
        $total['mrr'] = $MRR;
        $answerExistPercent = 100 * $answerExist / $numberOfSubmissions;
        $total['answer_exist_percent'] = $answerExistPercent;
        $avgAnswersPerQuestion = 100 * Submission::hasRank()->sum('avg_correct_answers') / $numberOfSubmissions;
        $total['avg_answers_per_question'] = $avgAnswersPerQuestion;


        //byType
        $measuresByType = ['list' => [
            'numberOfSubmissions' => 0,
            'mrr_summation' => 0,
            'mrr' => 0,
            'answer_exists' => 0,
            'answer_exist_percent' => 0,
            'avg_answers_per_question' => 0,
        ], 'numeric' => [
            'numberOfSubmissions' => 0,
            'mrr_summation' => 0,
            'mrr' => 0,
            'answer_exists' => 0,
            'answer_exist_percent' => 0,
            'avg_answers_per_question' => 0,
        ], 'paragraph' => [
            'numberOfSubmissions' => 0,
            'mrr_summation' => 0,
            'mrr' => 0,
            'answer_exists' => 0,
            'answer_exist_percent' => 0,
            'avg_answers_per_question' => 0,
        ]];
        $numberOfSubmissionsByType = Submission::hasRank()->selectRaw('COUNT(*) as count, question_type')->groupBy('question_type')->get()->pluck('count', 'question_type');
        foreach ($numberOfSubmissionsByType as $key => $numberOfSubmissionByType){
            $measuresByType[$key]['numberOfSubmissions'] = $numberOfSubmissionByType;
        }
        $mrr_sumsByType = Submission::hasRank()->where('best_rank', '>', '-1')->selectRaw('sum(1/best_rank) as sum, question_type')->groupBy('question_type')->get()->pluck('sum', 'question_type');
        foreach ($mrr_sumsByType as $key => $mrr_sumByType){
            $measuresByType[$key]['mrr_summation'] = $mrr_sumByType;
            $measuresByType[$key]['mrr'] = 100 * $mrr_sumByType / $measuresByType[$key]['numberOfSubmissions'];
        }
        $answerExistsByType = Submission::hasRank()->where('best_rank', '>', '-1')->selectRaw('COUNT(*) as count, question_type')->groupBy('question_type')->get()->pluck('count', 'question_type');
        foreach ($answerExistsByType as $key => $answerExistByType){
            $measuresByType[$key]['answer_exists'] = $answerExistByType;
            $measuresByType[$key]['answer_exist_percent'] = 100 * $answerExistByType / $measuresByType[$key]['numberOfSubmissions'];
        }

        $avgAnswersPerQuestionPerType = Submission::hasRank()->selectRaw('SUM(avg_correct_answers) as sum, question_type')->groupBy('question_type')->get()->pluck('sum', 'question_type');
        foreach ($avgAnswersPerQuestionPerType as $key => $avgAnswerPerQuestionPerType){
            $measuresByType[$key]['avg_answers_per_question'] = 100 * $avgAnswerPerQuestionPerType / $measuresByType[$key]['numberOfSubmissions'];
        }
        return view('results', compact('total', 'measuresByType'));

    }


    static function generateRandomString()
    {
        return date('YmdHi');
    }


}

