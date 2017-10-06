<?php

namespace App\Http\Controllers;

use App\Document;
use App\Form;
use Illuminate\Http\Request;

class DocumentController extends Controller
{


    public function allDocuments()
    {
        return Document::all();
    }

    public function getDocument(Document $document)
    {
        return $document;
    }

    public function saveDocument(Request $request, Form $form)
    {

        //check if link exist before( so we will not store it again)
        if (is_null($doc = Document::where('link', $request->get('link'))->first())) {
            $doc = $form->documents()->create($request->all());
        } else {
            $form->documents()->attach($doc->id);
        }

        return $doc->id;
    }
}
