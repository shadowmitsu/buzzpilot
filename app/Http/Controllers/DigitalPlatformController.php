<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DigitalPlatform;
use App\Models\InteractionType;
use Illuminate\Support\Facades\Storage;

class DigitalPlatformController extends Controller
{
    public function index()
    {
        $digitalPlatforms = DigitalPlatform::all();
        $interactionTypes = InteractionType::all();
        return view('digital_platforms.index', compact('digitalPlatforms', 'interactionTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $iconPath = null;
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('icons', 'public');
        }
    
        DigitalPlatform::create([
            'name' => $request->name,
            'icon' => $iconPath, 
            'status' => $request->status ?? true,
        ]);
    
        return redirect()->route('digital_platforms.index')->with('success', 'Digital platform created successfully.');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);
    
        $digitalPlatform = DigitalPlatform::findOrFail($id);
    
        if ($request->hasFile('icon')) {
            if ($digitalPlatform->icon) {
                Storage::disk('public')->delete($digitalPlatform->icon);
            }
            $iconPath = $request->file('icon')->store('icons', 'public');
            $digitalPlatform->icon = $iconPath;
        }
    
        $digitalPlatform->name = $request->name;
        $digitalPlatform->status = $request->status ?? true;
        $digitalPlatform->save();
    
        return redirect()->route('digital_platforms.index')->with('success', 'Digital platform updated successfully.');
    }

    public function destroy($a)
    {
        $digitalPlatform = DigitalPlatform::where('id', $a)
            ->first();
        $digitalPlatform->delete();
        return redirect()->back()->with('success', 'Digital Platform deleted successfully.');
    }
}
