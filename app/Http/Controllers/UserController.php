<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Récupération de l'utilisateur connecté
        $user = Auth::user();
        // Récupération des articles liés à l'utilisateur connecté
        $articles = Article::where('user_id', $user->id)->get();
        // Redirection à la vue
        return view('dashboard', [
            'articles' => $articles
        ]);
    }

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
