<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    
    protected $fillable = ['title', 'description', 'author', 'votes'];

    public function votes(){
        return $this->hasMany(Vote::class);
    }
}
