<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    public $timestamps = false;

    protected $guarded= ['id'];

    /**
     * Get the comments for the blog post.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }


}
