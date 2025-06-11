<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Idea;

class IdeaController extends Controller
{
    // fonction pour afficher la liste des idées
    public function index(){
        $ideas = Idea::orderBy('votes', 'desc')->get();
        return view('idea',compact('ideas'));
    }

    // fonction pour retourner la page des idées

    // fonction pour stocker idée dans la base de données
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'title' => 'required|string',
                'description' => 'required|string',
                'author' => 'required|string|max:100',
            ]
            );
            $validated['votes'] = 0;
            Idea::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'author' => $validated['author'],
                'votes' => $validated['votes'],
            ]);

            return redirect()->route('index')->with('success', 'Idée ajoutée avec succès !');

    }
}
