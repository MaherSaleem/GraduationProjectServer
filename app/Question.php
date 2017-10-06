<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{


    protected $fillable = ['text'];
    public $timestamps = false;

    public function forms()
    {
        return $this->hasMany(Form::class);
    }
}
