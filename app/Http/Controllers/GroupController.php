<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GroupController extends Controller {
    public function index() {
        $groups = Group::all();
        return Inertia::render('Groups', [
            'groups' => $groups
        ]);
    }

    public function group(Request $request) {
        $group = Group::find($request->input('id'));
        $users = $group->users()->get();
        $isFollowing = auth()->check() && auth()->user()->followingGroups()->where('group_id', $group->id)->exists();

        return Inertia::render('Group', [
            'group' => $group,
            'users' => $users,
            'isFollowing' => $isFollowing,
        ]);
    }

    public function show() {
        $groups = Group::all();

        return Inertia::render('Explore', [
            'posts' => $posts
        ]);
    }

    public function store(StoreGroupRequest $request) {
        $newGroup = Group::create($request->validated());
        Auth::user()->groups()->attach($newGroup->id);
        return to_route('groups');
    }

    public function toggleFollow(Group $group) {
        $user = auth()->user();

        if ($user->followingGroups()->where('group_id', $group->id)->exists()) {
            $user->followingGroups()->detach($group->id);
        } else {
            $user->followingGroups()->attach($group->id);
        }

        return back();
    }
}