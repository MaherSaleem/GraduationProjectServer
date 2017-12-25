<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public $timestamps = false;

    protected $guarded= ['id'];

    /**
     * Get the comments for the blog post.
     */
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }


}
