<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DigitalPlatform;
use App\Models\InteractionType;
use App\Models\OriginalService;
use App\Models\PrimaryService;
use Illuminate\Http\Request;

class OriginalServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = OriginalService::query();
    
        if (!empty($request->interaction_name) && $request->interaction_name != 'All') {
            $query->where('name', 'LIKE', '%' . $request->interaction_name . '%');
        }
    
        if (!empty($request->platform_name) && $request->platform_name != "All") {
            $query->where('name', 'LIKE', '%' . $request->platform_name . '%');
        }

        if (!empty($request->search)) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }
    
        $digitals = DigitalPlatform::all();
        $interactions = InteractionType::all();
    
        $services = $query->paginate(100);
    
        return view('original_services.index', compact('services', 'digitals', 'interactions'));
    }

    public function updateOriginalPlatform()
    {
        $platforms = DigitalPlatform::all();
        foreach($platforms as $plt) {
            $originalServices = OriginalService::where('category', 'LIKE', '%'.$plt->name.'%')
                ->get();
            foreach($originalServices as $orgs) {
                $orgs->digital_platform_id = $plt->id;
                $orgs->save();
            }
        }
    }
   
    public function updateOriginalInteraction()
    {
        $interactions = InteractionType::all();
        $orgs = [];
        foreach($interactions as $intr) {
            $originalServices = OriginalService::where('name', 'LIKE', '%'.$intr->name.'%')
                ->get();
            foreach($originalServices as $orgs) {
                $orgs->interaction_type_id = $intr->id;
                $orgs->save();
            }
        }

        // return $orgs;
    }

    public function assignPrimaryService($a)
    {
        $originalService = OriginalService::where('id', $a)
            ->first();

        if(!$originalService) {
            return redirect()->route('original_services.index')->with('error', 'Sorry no data original service.');
        }

        $checkPrimaryService = PrimaryService::where('original_service_id', $a)
            ->first();

        if($checkPrimaryService) {
            return redirect()->route('original_services.index')->with('error', 'Sorry can`t duplicate data primary service.');
        }

        $assign = new PrimaryService();
        $assign->original_service_id = $a;
        $assign->digital_platform_id = $originalService->digital_platform_id;
        $assign->interaction_type_id = $originalService->interaction_type_id;
        $assign->name = $originalService->name;
        $assign->category = $originalService->category;
        $assign->old_price = $originalService->price;
        $assign->price = $originalService->price;
        $assign->min = $originalService->min;
        $assign->max = $originalService->max;
        $assign->type = $originalService->price <= 75000 ? 'hemat' : 'sultan';
        $assign->save();

        return redirect()->route('original_services.index')->with('success', 'Success assign '.$originalService->name.' to primary service.');
    }
    
}
