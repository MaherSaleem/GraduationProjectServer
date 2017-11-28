<?php

namespace App\Http\Controllers;

use App\Document;
use App\Form;
use App\Question;
use Illuminate\Http\Request;

class FormController extends Controller
{

    public function allForms()
    {
        return Form::all();
    }

    public function getForm(Form $form)
    {
        return $form;
    }

    public function getDocuments(Form $form)
    {
        return $form->documents;
    }

    public function getDocumentsForRank(Form $form)
    {
        $formDocuments = $form->documents()->select('documents.id as id','contentRank','urlRank')->get();
        return $formDocuments;
    }

    public function storeForm(Request $request, Question $question)
    {
        return $question->forms()->create($request->all())->id;

    }


}
