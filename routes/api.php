<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\StorePostRequest;
use App\Models\User;
use App\Http\Controllers\Api\TranslationController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $token = $user->createToken('android-app')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'token' => $token, 
        'user' => $user,
    ]);
});

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);
 
    $user = User::where('email', $request->email)->first();
 
    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
 
    $token = $user->createToken('android-app')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'token' => $token, 
        'user' => $user,
    ]);
});

Route::post('/translate', [TranslationController::class, 'translate']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts', function (Request $request) {
        return $request->user()->posts()->get();
    });
    Route::post('/posts', function (Request $request) {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
        ]);
    
        // Create a new post for the authenticated user
        $post = $request->user()->posts()->create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);
    
        // Return the newly created post as JSON
        return $post;

        $newPost = Post::create($request->validated());
        Auth::user()->posts()->attach($newPost->id);
        return $newPost;
    });
    Route::get('/users', function (Request $request) {
        return User::all();
    });
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
});

