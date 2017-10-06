<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    public $timestamps = false;

    protected $fillable = ['text' , 'question_id'];

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
