<?php

namespace App\Http\Controllers\Web;

use App\Models\Person;
use App\Models\Relationship;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShezhireController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $person = $user->person()->with(['children', 'parents', 'spouses'])->first();

        return Inertia::render('Shezhire/Index', [
            'person' => $person,
        ]);
    }

    public function addRelative(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'type' => 'required|in:child,parent,spouse',
        ]);

        $user = Auth::user();
        $mainPerson = $user->person;

        // Create the new relative Person
        $newPerson = Person::create([
            'created_by' => $user->id,
            'full_name' => $request->full_name,
            'birth_date' => null,
            'gender' => null,
            'bio' => null,
        ]);

        // Depending on relationship type, link them
        if ($request->type === 'child') {
            Relationship::create([
                'person1_id' => $mainPerson->id,
                'person2_id' => $newPerson->id,
                'type' => 'parent',
            ]);
        } elseif ($request->type === 'parent') {
            Relationship::create([
                'person1_id' => $newPerson->id,
                'person2_id' => $mainPerson->id,
                'type' => 'parent',
            ]);
        } elseif ($request->type === 'spouse') {
            Relationship::create([
                'person1_id' => $mainPerson->id,
                'person2_id' => $newPerson->id,
                'type' => 'spouse',
            ]);
        }

        return redirect()->route('shezhire.index')->with('success', 'Relative added successfully!');
    }
}