<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($name)
    {
        $user = User::where('name', $name)
            ->with(['person', 'posts', 'relationships'])
            ->firstOrFail();

        return response()->json($user);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'bio' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->bio = $validated['bio'] ?? $user->bio;
        $user->save();

        return response()->json($user);
    }
}
