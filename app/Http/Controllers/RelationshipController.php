<?php

namespace App\Http\Controllers;

use App\Models\Relationship;
use Illuminate\Http\Request;

class RelationshipController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'person_id' => 'required|exists:people,id',
            'relative_id' => 'required|exists:people,id|different:person_id',
            'type' => 'required|in:parent,child,spouse',
        ]);

        if (Relationship::where([
            ['person_id', $validated['relative_id']],
            ['relative_id', $validated['person_id']],
            ['type', $validated['type']]
        ])->exists()) {
            return back()->withErrors(['duplicate' => 'Мұндай байланыс бар']);
        }

        Relationship::createBidirectional(
            $validated['person_id'],
            $validated['relative_id'],
            $validated['type']
        );

        return back()->with('success', 'Байланыс қосылды');
    }
}
