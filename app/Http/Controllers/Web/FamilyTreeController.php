<?php

namespace App\Http\Controllers\Web;

use App\Models\Person;
use App\Models\Relationship;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FamilyTreeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rootPerson = $user->person;

        return Inertia::render('FamilyTree/Index', [
            'tree' => $this->buildTree($rootPerson),
        ]);
    }

    private function buildTree(Person $person)
    {
        return [
            'id' => $person->id,
            'name' => $person->name,
            'gender' => $person->gender,
            'children' => $person->children->map(fn($child) => $this->buildTree($child)),
        ];
    }

    public function create(Person $parent = null)
    {
        return Inertia::render('FamilyTree/Create', ['parent' => $parent]);
    }

    public function store(Request $request)
    {
        $person = Person::create($request->only('name', 'gender'));

        if ($request->parent_id) {
            Relationship::create([
                'person_id' => $request->parent_id,
                'relative_id' => $person->id,
                'type' => 'parent',
            ]);
        }

        return redirect()->route('family.tree');
    }

}