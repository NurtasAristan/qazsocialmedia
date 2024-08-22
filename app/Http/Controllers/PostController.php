<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller {
    public function index() {
        $myPosts = Auth::user()->posts()->with('categories')->get();
        $categories = Category::all();

        return Inertia::render('Dashboard', [
            'myPosts' => $myPosts,
            'categories' => $categories
        ]);
    }

    public function store(StorePostRequest $request) {
        $newPost = Post::create($request->safe()->only(['title', 'content']));
        Auth::user()->posts()->attach($newPost->id);
        $myPosts->categories()->attach($request->safe()->only(['category_id']));
        return to_route('dashboard');
    }
}