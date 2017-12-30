<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{

    protected $guarded= ['id'];

    /**
     * Get the comments for the blog post.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function scopeHasRank($query){
            return $query->whereNotNull('best_rank');
    }

    public function ranks(){
        return $this->hasMany(Rank::class);
    }


}
