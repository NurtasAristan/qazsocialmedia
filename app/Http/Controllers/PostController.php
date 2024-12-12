<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller {
    public function index() {
        $user = Auth::user();
        $myPosts = Auth::user()->posts()->get();

        return Inertia::render('Dashboard', [
            'user' => $user,
            'myPosts' => $myPosts
        ]);
    }

    public function post(Request $request) {
        $post = Post::find($request->input('id'));

        return Inertia::render('Post', [
            'post' => $post
        ]);
    }

    public function show(Request $request) {
        $posts = Post::with('users')->get();
        
        //return response()->json($posts);

        return Inertia::render('Explore', [
            'posts' => $posts
        ]);
    }

    public function store(StorePostRequest $request) {
        $newPost = Post::create($request->validated());
        Auth::user()->posts()->attach($newPost->id);
        return to_route('dashboard');
    }

    public function update(Request $request, Post $post) {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update($validatedData);

        return redirect()->route('dashboard')->with('status', 'Post updated successfully.');
    }

    public function destroy(string $id) {
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('dashboard')->with('status', 'Post deleted');
    }
}