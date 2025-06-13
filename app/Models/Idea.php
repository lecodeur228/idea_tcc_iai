<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Idea extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'description', 'author', 'votes'];

    public function votes(){
        return $this->hasMany(Vote::class);
    }
}
