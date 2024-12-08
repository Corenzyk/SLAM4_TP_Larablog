<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        {{$categories = Category::all();}}
        return view('articles.create',[
            'categories'=>$categories
        ]);
    }

    public function store(Request $request)
    {
        // Récupération des données transmises du formulaire
        $data = $request->only(['title', 'content', 'draft']);
        // Récupération de l'auteur de l'article (id du user connecté)
        $data['user_id'] = Auth::user()->id;
        // Récupération de l'état de l'article (brouillon ou non)
        $data['draft'] = isset($data['draft']) ? 1 : 0;
        // Définition des likes par défaut
        $data['likes'] = 0;
        // Création de l'article
        $article = Article::create($data);
        // Ajout des category dans la table pivot
        $article->categories()->sync($request->input('category'));
        // Redirection de l'utilisateur vers la page de ses articles
        return redirect()->route('dashboard');
    }

    public function edit(Article $article)
    {
        // Vérification de si l'user connecté est bien l'auteur, renvoie une erreur forbidden si non
        if ($article->user_id !== Auth::user()->id) {
            abort(403)->with('error', 'Vous ne pouvez pas modifier cet article');
        }
        
        {{$categories = Category::all();}}

        // Renvoie de la vue avec l'article prêt à être modifié
        return view('articles.edit', [
            'article' => $article,
            'categories'=>$categories
        ]);
    }

    public function update(Request $request, Article $article)
    {
        // Vérification de si l'user connecté est bien l'auteur, renvoie une erreur forbidden si non
        if ($article->user_id !== Auth::user()->id) {
            abort(403)->with('error', 'Vous ne pouvez pas modifier cet article');
        }

        // Récupération des données transmises du formulaire
        $data = $request->only(['title', 'content', 'draft']);
        // Récupération de l'état de l'article (brouillon ou non)
        $data['draft'] = isset($data['draft']) ? 1 : 0;
        // Mise à jour de l'article
        $article->update($data);
        // Ajout des category dans la table pivot
        $article->categories()->sync($request->input('category'));
        // Redirection de l'utilisateur au dashboard (avec parametre pour message flash)
        return redirect()->route('dashboard')->with('success', 'Article modifié !');
    }

    public function remove(Request $request, Article $article)
    {
        // Vérification de si l'user connecté est bien l'auteur, renvoie une erreur forbidden si non
        if ($article->user_id !== Auth::user()->id) {
            abort(403)->with('error', 'Vous ne pouvez pas supprimer cet article');
        }

        // Suppression de l'article
        $article->delete();

        // Redirection de l'utilisateur au dashboard (avec parametre pour message flash)
        return redirect()->route('dashboard')->with('success', 'Article supprimé !');
    }
}
