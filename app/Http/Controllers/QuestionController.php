<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{


    public function allQuestions(){
        return Question::all();
    }
    public function getQuestion(Question $question){
        return $question;
    }

    public function storeQuestion(Request $request){

        return Question::create($request->all())->id;
    }
}

