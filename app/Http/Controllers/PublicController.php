<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(User $user)
    {
        // On récupère les articles publiés de l'utilisateur
        $articles = Article::where('user_id', $user->id)->where('draft', 0)->get();
    
        // On retourne la vue
        return view('public.index', [
            'articles' => $articles,
            'user' => $user
        ]);
    }

    public function show(User $user, Article $article)
    {
        if ($article->user_id !== $user->id) {
            abort(403)->with('error', 'Vous ne pouvez pas consultez cet article');
        }

        // Reste à compléter
        // $article est l'article à afficher

        // Vérifier que l'article est publié (draft == 0)
    }
}
