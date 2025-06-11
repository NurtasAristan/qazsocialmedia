<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Like;
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

        return Inertia::render('Home', [
            'user' => $user,
            'myPosts' => $myPosts
        ]);
    }

    public function like(Post $post) {
        $like = new Like;
        $like->post_id = $post->id;
        $like->user_id = Auth::id();
        $like->save();
        return back();
    }

    public function post(string $id) {
        $post = Post::find($id);
        return Inertia::render('Post', [
            'post' => $post
        ]);
    }

    public function show(Request $request) {
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
    
            // Search posts by title or content
            $posts = Post::with('user')->where(function ($query) use ($searchTerm) {
                $query->where('content', 'like', '%' . $searchTerm . '%');
            })->get();
        } else {
            $posts = Post::with(['user', 'likes'])->get();
        }

        return Inertia::render('Explore', [
            'userId' => Auth::id(),
            'posts' => $posts
        ]);
        //
    }

    public function store(StorePostRequest $request) {
        $validated = $request->validated();

        $post = new Post;
        $post->user_id = Auth::id();
        $post->content = $request->content;
        $post->save();
        
        return to_route('home');
    }

    public function update(Request $request, Post $post) {

        $validatedData = $request->validate([
            'content' => 'required|string',
        ]);

        $post->update($validatedData);

        return redirect()->route('home')->with('status', 'Post updated successfully.');
    }

    public function destroy(string $id) {
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('home')->with('status', 'Post deleted');
    }
}