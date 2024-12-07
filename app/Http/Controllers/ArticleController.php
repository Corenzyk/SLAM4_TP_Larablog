<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function like(Request $request, int $idArticle)
    {
        if (Auth::check()){
            Article::where('id', $idArticle)->increment('likes');
            return redirect()->back();
        }
        else{
            return redirect()->route('login');
        }
    }
}
