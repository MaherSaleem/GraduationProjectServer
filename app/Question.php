<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{


    protected $fillable = ['text'];
    public $timestamps = false;
    protected $guarded= ['id'];
    public function forms()
    {
        return $this->hasMany(Form::class);
    }
}
