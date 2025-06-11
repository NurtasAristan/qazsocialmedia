<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Nationality;
use App\Models\User;
use App\Models\Settlement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller {
    public function index() {
        $users = User::with(['nationality:id,name', 'settlement'])->get();
        $settlements = Settlement::all();
        $nationalities = Nationality::all();

        return Inertia::render('Friends', [
            'users' => $users,
            'settlements' => $settlements,
            'nationalities' => $nationalities
        ]);
    }

    public function user(Request $request) {
        $user = User::find($request->input('id'));
        $posts = $user->posts()->get();

        return Inertia::render('User', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function users() {
        $users = User::all();
        return response()->json($users);
    }

    public function show(User $user)
    { 
        $user->load(['nationality', 'settlement', 'posts.user'])->firstOrFail(); 
        return Inertia::render('User', [
            'user' => $user
        ]);
    }
}