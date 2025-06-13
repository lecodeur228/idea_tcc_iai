<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Idea;

class IdeaController extends Controller
{
    public function index(){
        $ideas = Idea::orderBy('votes', 'desc')->get();
        return response()->json($ideas,200);
    }
}
