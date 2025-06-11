<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonRequest;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PersonController extends Controller {
    public function index() {
        return Inertia::render('Person');
    }

    public function group(Request $request) {
        $group = Group::find($request->input('id'));
        $users = $group->users()->get();

        return Inertia::render('Group', [
            'group' => $group,
            'users' => $users
        ]);
    }

    public function show() {
        $groups = Group::all();

        return Inertia::render('Explore', [
            'posts' => $posts
        ]);
    }

    public function store(StorePersonRequest $request) {
        $validated = $request->validated();
        $validated['created_by'] = Auth::id(); // add user ID

        Person::create($validated);
        return to_route('person');
    }

    public function showFamily() 
    {
        
    }
}