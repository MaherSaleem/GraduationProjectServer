<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['link', 'text', 'document_id', 'form_id'];
    public $timestamps = false;

    public function forms()
    {
        return $this->belongsToMany(Form::class);
    }
}
