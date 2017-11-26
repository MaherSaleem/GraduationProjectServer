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
        $contentRank = $request->get('contentRank');
        $urlRank = $request->get('urlRank');
        if (is_null($doc = Document::where('link', $request->get('link'))->first())) {
            $document = Document::create($request->all());
            $doc = $form->documents()->save($document, ['contentRank' => $contentRank, 'urlRank'=> $urlRank]);
        } else {
            $form->documents()->attach($doc->id, ['contentRank' => $contentRank, 'urlRank'=> $urlRank]);
        }

        return $doc->id;
    }
}
