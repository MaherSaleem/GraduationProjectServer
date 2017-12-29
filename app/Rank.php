<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    public $timestamps = false;

    protected $guarded= ['id'];

    public function submission(){
        return $this->belongsTo(Submission::class);
    }
}
