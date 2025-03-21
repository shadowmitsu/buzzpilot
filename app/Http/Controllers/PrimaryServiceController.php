<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DigitalPlatform;
use App\Models\InteractionType;
use App\Models\PrimaryService;
use Illuminate\Http\Request;

class PrimaryServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = PrimaryService::query();
    
        if (!empty($request->search)) {
            $query->where('name','LIKE', '%'.$request->search.'%');
        }
        
        if (!empty($request->platform_id) && $request->platform_id != 'All') {
            $query->where('digital_platform_id', $request->platform_id);
        }
    
        if (!empty($request->interaction_id) && $request->interaction_id != 'All') {
            $query->where('interaction_type_id', $request->interaction_id);
        }
    
        $digitals = DigitalPlatform::all();
        $interactions = InteractionType::all();
    
        $services = $query->paginate(25);
    
        return view('primary_services.index', compact('services', 'digitals', 'interactions'));
    }

    public function detail($a)
    {
        $service = PrimaryService::where('id', $a)
            ->first();

        return view('primary_services.detail', compact('service'));
    }

    public function update(Request $request, $a)
    {
        $service = PrimaryService::where('id', $a)
            ->first();

        if(!$service) {
            return redirect()->route('primary_services.index')->with('error', 'Sorry primary service not found.');
        }

        $service->name = $request->service_name;
        $service->price = $request->price;
        $service->min = $request->min_service;
        $service->max = $request->max_service;
        $service->type = $request->service_type;
        $service->status = $request->service_status;
        $service->save();

        return redirect()->route('primary_services.index')->with('success', 'Success update primary service.');
    }
    
}
