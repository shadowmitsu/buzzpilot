<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InteractionType;
use Illuminate\Http\Request;

class IntercationTypeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        InteractionType::create([
            'name' => $request->name,
        ]);
    
        return redirect()->route('digital_platforms.index')->with('success', 'Digital platform created successfully.');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $interactionType = InteractionType::findOrFail($id);

    
        $interactionType->name = $request->name;
        $interactionType->save();
    
        return redirect()->route('digital_platforms.index')->with('success', 'Digital platform updated successfully.');
    }

    public function destroy($a)
    {
        InteractionType::where('id', $a)
            ->delete();
        return redirect()->back()->with('success', 'Digital Platform deleted successfully.');
    }
}
