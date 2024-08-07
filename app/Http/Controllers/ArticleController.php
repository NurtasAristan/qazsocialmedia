<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;

class ArticleController extends Controller {
    public function index() {
        $articles = Auth::user()->articles;
        return Inertia::render('Dashboard', [
            'articles' => $articles
        ]);
    }

    public function store(StoreArticleRequest $request) {
        $newArticle = Article::create($request->validated());
        Auth::user()->articles()->attach($newArticle->id);
        return to_route('dashboard');
    }
}