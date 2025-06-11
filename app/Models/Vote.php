<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['id_address','idea_id'];

    public function idea(){
        return $this->belongsTo(Idea::class);
    }
}
