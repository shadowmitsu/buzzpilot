<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\OriginalService;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('category')->paginate(100);
        return view('services.index', compact('services'));
    }
    
    public function importServices(Request $request)
    {
        $response = Http::asForm()->post('https://irvankedesmm.co.id/api/services', [
            'api_id' => '37638',
            'api_key' => 'evvpik-swhzqg-qtuwi1-jpxzl1-k40yfu',
        ]);
        
        $apiResponse = $response->json()['data'];
        
        foreach ($apiResponse as $item) {
            OriginalService::updateOrCreate(
                ['service_code' => $item['id']],
                [
                    'service_code' => $item['id'],
                    'name' => $item['name'],
                    'category' => $item['category'],
                    'type' => $item['type'], 
                    'price' => $item['price'],
                    'min' => $item['min'],
                    'max' => $item['max'],
                    'refill' => $item['refill'],
                    'status' => $item['status'],
                    'note' => $item['note']
                ]
            );
        }

        return response()->json(['message' => 'Services imported successfully'], 200);
    }

    public function detail($a)
    {
        $service = Service::where('id', $a)
            ->first();
        return view('services.detail', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::find($id);
        $service->min = $request->input('min');
        $service->max = $request->input('max');
        $service->price = $request->input('price');
        $service->refill = $request->input('refill');
        $service->save();

        return redirect()->route('services.detail', $service->id)->with('success', 'Service updated successfully');
    }

}
