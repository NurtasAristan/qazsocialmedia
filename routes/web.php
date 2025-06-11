<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Web\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FcmController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Web\ShezhireController;
use App\Http\Controllers\Web\FamilyTreeController;
use App\Http\Request\StorePostRequest;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'language' => App::getLocale(),
    ]);
});

Route::put('update-device-token', [FcmController::class, 'updateDeviceToken']);
Route::post('send-fcm-notification', [FcmController::class, 'sendFcmNotification']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/home', [PostController::class, 'index'])->name('home');
    Route::post('/home', [PostController::class, 'store'])->name('home.store');
    Route::delete('/home/{id}', [PostController::class, 'destroy'])->name('home.destroy');

    Route::get('/explore', [PostController::class, 'show'])->name('explore');

    Route::get('/friends', [UserController::class, 'index'])->name('friends');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::post('/chat/create', [ChatController::class, 'store']);
    Route::get('/chats/{chat}/messages', [ChatController::class, 'messages']);
    Route::post('/chats/{chat}/messages', [ChatController::class, 'sendMessage']);

    Route::get('/groups', [GroupController::class, 'index'])->name('groups');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/group', [GroupController::class, 'group'])->name('group');
    Route::post('/groups/{group}/follow', [GroupController::class, 'toggleFollow'])->name('groups.follow');

    Route::get('/post/{id}', [PostController::class, 'post'])->name('home.post');

    Route::get('/person', [PersonController::class, 'index'])->name('person');
    Route::post('/person', [PersonController::class, 'store'])->name('person.store');

    Route::post('/posts/{post}', [PostController::class, 'update'])->name('posts.update');

    Route::get('/feed', function () { return Inertia::render('KnowledgeFeed'); })->name('feed');

    Route::get('/profile/{name}', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    Route::get('/shezhire', [ShezhireController::class, 'index'])->name('shezhire.index');
    Route::post('/shezhire/add-relative', [ShezhireController::class, 'addRelative'])->name('shezhire.addRelative');

    Route::get('/user', [UserController::class, 'user'])->name('user');
    Route::get('/user/{user:name}', [UserController::class, 'show']);
    Route::post('/users/{user}/follow', [FollowController::class, 'follow'])->name('users.follow');
    Route::delete('/users/{user}/unfollow', [FollowController::class, 'unfollow'])->name('users.unfollow');

    Route::get('/family-tree', [FamilyTreeController::class, 'index'])->name('family.tree');
    Route::get('/family-tree/create/{parent?}', [FamilyTreeController::class, 'create'])->name('family.tree.create');
    Route::post('/family-tree', [FamilyTreeController::class, 'store'])->name('family.tree.store');

    Route::post('/posts/{post}/like', [PostController::class, 'like']);

    Route::get('/gettranslate', function () {
        return Inertia::render('TranslateForm');
    });

    Route::get('/family', [PersonController::class, 'showFamily']);

    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
    Route::post('/posts/{post}/likes', [LikeController::class, 'toggleLike']);

    Route::get('/familytree', function () {
        return Inertia::render('FamilyTree2');
    })->name('familytree');
});
