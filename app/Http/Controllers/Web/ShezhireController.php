<?php

namespace App\Http\Controllers\Web;

use App\Models\Person;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShezhireController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Assuming each user is connected to a Person model
        $rootPerson = $user->person;

        if (!$rootPerson) {
            return Inertia::render('Shezhire/NoPerson', [
                'message' => 'No associated person found. Please create your profile.'
            ]);
        }

        // Load relationships: parents, children, spouses, etc.
        $familyTree = $this->buildTree($rootPerson);

        return Inertia::render('Shezhire/Index', [
            'tree' => $familyTree,
            'rootPersonId' => $rootPerson->id,
        ]);
    }

    protected function buildTree(Person $person)
    {
        return $person->load([
            'father',
            'mother',
            'spouses',
            'children' => function ($query) {
                $query->with(['spouses', 'children']); // Recursive children tree (to 2 levels deep)
            },
        ]);
    }
}