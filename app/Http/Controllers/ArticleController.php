<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ArticleController extends Controller {
    public function index() {
        $articles = Auth::user()->articles();
        return Inertia::render('Dashboard', [
            'articles' => $articles
        ]);
    }
}