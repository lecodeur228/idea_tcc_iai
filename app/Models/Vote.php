<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vote extends Model
{
    use HasFactory;
    protected $fillable = ['id_address','idea_id'];

    public function idea(){
        return $this->belongsTo(Idea::class);
    }
}
