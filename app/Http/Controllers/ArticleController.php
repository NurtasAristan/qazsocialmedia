<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ArticleController extends Controller {
    public function index() {
        $myArticles = Auth::user()->articles()->with('categories')->get();
        $categories = Category::all();

        return Inertia::render('Dashboard', [
            'myArticles' => $myArticles,
            'categories' => $categories
        ]);
    }

    public function store(StoreArticleRequest $request) {
        $newArticle = Article::create($request->safe()->only(['title', 'content']));
        Auth::user()->articles()->attach($newArticle->id);
        $newArticle->categories()->attach($request->safe()->only(['category_id']));
        return to_route('dashboard');
    }
}