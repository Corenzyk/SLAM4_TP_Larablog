<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CommentController;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::check()){
            // Récupération des données transmises du formulaire
            $data = $request->only(['content', 'articleId']);
            // Récupération de l'article (id de l'article de la page)
            $data['article_id'] = $request->articleId;
            // Récupération de l'auteur de l'article (id du user connecté)
            $data['user_id'] = Auth::user()->id;
            // Création du commentaire
            $commentaire = Comment::create($data);
            // Redirection de l'utilisateur vers le l'article
            return redirect()->back();
        }
        else{
            return redirect()->route('login');
        }
    }
}