<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller {
    public function index() {
        $myPosts = Auth::user()->posts()->get();
        $categories = Category::all();

        return Inertia::render('Dashboard', [
            'myPosts' => $myPosts,
            'categories' => $categories
        ]);
    }

    public function show() {
        $posts = Post::all();

        return Inertia::render('Explore', [
            'posts' => $posts
        ]);
    }

    public function store(StorePostRequest $request) {
        $newPost = Post::create($request->validated());
        Auth::user()->posts()->attach($newPost->id);
        return to_route('dashboard');
    }
}