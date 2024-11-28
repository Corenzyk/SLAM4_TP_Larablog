<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        // Récupération des données transmises du formulaire
        $data = $request->only(['title', 'content', 'draft']);
        // Récupération de l'auteur de l'article (id du user connecté)
        $data['user_id'] = Auth::user()->id;
        // Récupération de l'état de l'article (brouillon ou non)
        $data['draft'] = isset($data['draft']) ? 1 : 0;
        // Création de l'article
        $article = Article::create($data);
        // Redirection de l'utilisateur vers la page de ses articles
        return redirect()->route('dashboard');
    }
}
