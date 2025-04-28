<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FcmController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Web\ShezhireController;
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
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [PostController::class, 'store'])->name('dashboard.store');
    Route::delete('/dashboard/{id}', [PostController::class, 'destroy'])->name('dashboard.destroy');

    Route::get('/explore', [PostController::class, 'show'])->name('explore');

    Route::get('/friends', [UserController::class, 'index'])->name('friends');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat');

    Route::get('/groups', [GroupController::class, 'index'])->name('groups');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/group', [GroupController::class, 'group'])->name('group');
    Route::post('/groups/{group}/follow', [GroupController::class, 'toggleFollow'])->name('groups.follow');

    Route::get('/post/{id}', [PostController::class, 'post'])->name('dashboard.post');

    Route::get('/user', [UserController::class, 'user'])->name('user');

    Route::get('/person', [PersonController::class, 'index'])->name('person');
    Route::post('/person', [PersonController::class, 'store'])->name('person.store');

    Route::post('/posts/{post}', [PostController::class, 'update'])->name('posts.update');

    Route::get('/feed', function () {
        return Inertia::render('KnowledgeFeed');
    })->name('feed');

    Route::get('/profile/{name}', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    Route::get('/shezhire', [ShezhireController::class, 'index'])->name('shezhire.index');
    Route::post('/shezhire/add-relative', [ShezhireController::class, 'addRelative'])->name('shezhire.addRelative');
});
