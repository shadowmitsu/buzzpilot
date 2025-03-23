<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DigitalPlatform;
use App\Models\InteractionType;
use App\Models\PrimaryService;
use App\Models\Service;
use App\Models\TransactionService;
use App\Models\UserBalance;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UserTransactionController extends Controller
{
    public function index(Request $request)
    {
        $setting = WebsiteSetting::first();
        $transactionProcess = TransactionService::where('user_id', Auth::user()->id)    
            ->where('status', 'process')
            ->get();
        foreach($transactionProcess as $trp) {
            try {
                $responseCheckOrder = Http::asForm()->post('https://irvankedesmm.co.id/api/status', [
                    'api_id'   => $setting->irvan_app_id,
                    'api_key'  => $setting->irvan_app_key,
                    'id'       => $trp->trx_id,
                ]);
            } catch (\Exception $e) {
                continue;
            }
        
            if ($responseCheckOrder->failed()) {
                continue;
            }
    
            $startCount = data_get($responseCheckOrder->json(), 'data.start_count');
            $remainingAmount = data_get($responseCheckOrder->json(), 'data.remains');
            $status = data_get($responseCheckOrder->json(), 'data.status');

            $trp->amount_before = $startCount;
            $trp->remaining_amount = $remainingAmount;
            if($status == 'Success') {
                $trp->status = 'success';
            }
            $trp->save();
        }

        $transactionServices = TransactionService::where('user_id', Auth::user()->id)
            ->paginate(10);

        return view('users.transactions.index', compact('transactionServices'));
    }

    public function create() 
    {
        $digitalPlatforms = DigitalPlatform::where('status', 1)->get();
        $interactionTypes = InteractionType::all();
        return view('users.transactions.create', compact('digitalPlatforms', 'interactionTypes'));
    }

    public function massCreate() 
    {
        $digitalPlatforms = DigitalPlatform::where('status', 1)->get();
        $interactionTypes = InteractionType::all();
        return view('users.transactions.mass', compact('digitalPlatforms', 'interactionTypes'));
    }

    public function getServices($platformId, $interactionId)
    {
        $services = PrimaryService::where('digital_platform_id', $platformId)
                                ->where('interaction_type_id', $interactionId)
                                ->get();
        return response()->json($services);
    }


    public function getServicesByCategory($categoryId)
    {
        $services = Service::where('category_id', $categoryId)->where('status', 1)->get();
        return response()->json($services);
    }


    public function storeTransaction(Request $request)
    {
        $setting = WebsiteSetting::first();
        try{
            $validator = Validator::make($request->all(), [
                'service_id'  => 'required|exists:primary_services,id',
                'target_link' => 'required|url',
                'quantity'    => 'required|integer|min:1',
            ]);
        
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        
            $service = PrimaryService::find($request->service_id);
            if (!$service) {
                return redirect()->back()->with('error', 'Service not found');
            }

            $userBalance = UserBalance::where('user_id', Auth::user()->id)
                    ->first();
            if(!$userBalance) {
                return redirect()->back()->with('error', 'Wallet user not found');
            }

            $subtotal = ($request->quantity / 1000) * $service->price;

            if($subtotal > $userBalance->balance) {
                return redirect()->back()->with('error', 'Balance not enough');
            }
            try {
                if($service->type = "Default") {
                    $response = Http::asForm()->post($setting->irvan_url.'/order', [
                        'api_id'   => $setting->irvan_app_id,
                        'api_key'  => $setting->irvan_app_key,
                        'service'  => $service->originalService->service_code,
                        'target'   => $request->target_link,
                        'quantity' => $request->quantity,
                        'comments' => $request->custom_comments,
                    ]);
                }else if($service->type == 'Custom Comments') {
                    $response = Http::asForm()->post($setting->irvan_url.'/order', [
                        'api_id'   => $setting->irvan_app_id,
                        'api_key'  => $setting->irvan_app_key,
                        'service'  => $service->originalService->service_code,
                        'target'   => $request->target_link,
                        'comments' => $request->custom_comments,
                    ]);
                    
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to connect to external service.');
            }
        
            if ($response->failed()) {
                return $response->json();
                return redirect()->back()->with('error', 'Order failed, please try again.');
            }
        
            $orderId = data_get($response->json(), 'data.id');
            if (!$orderId) {
                return redirect()->back()->with('error', 'Invalid response from API.');
            }
        
            try {
                $responseCheckOrder = Http::asForm()->post($setting->irvan_url.'/status', [
                    'api_id'   => $setting->irvan_app_id,
                    'api_key'  => $setting->irvan_app_key,
                    'id'       => $orderId,
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to check order status.');
            }
        
            if ($responseCheckOrder->failed()) {
                return redirect()->back()->with('error', 'Failed to check order status.');
            }
        
            $startCount = data_get($responseCheckOrder->json(), 'data.start_count');
            $remainingAmount = data_get($responseCheckOrder->json(), 'data.remains');
        
            try {
                $transaction = new TransactionService();
                $transaction->user_id = Auth::user()->id;
                $transaction->primary_service_id = $service->id;
                $transaction->digital_platform_id = $service->digital_platform_id;
                $transaction->interaction_type_id = $service->interaction_type_id;
                $transaction->trx_code = $orderId;
                $transaction->name = $service->name;
                $transaction->category = $service->originalService->category;
                $transaction->type = $service->originalService->type;
                $transaction->price = $service->price;
                $transaction->refill = $service->refill;
                $transaction->qty = $request->quantity;
                $transaction->start_count = $startCount;
                $transaction->remains = $remainingAmount;
                $transaction->status = 'process';
                $transaction->target_link = $request->target_link;
                $transaction->total = round($subtotal);
                $transaction->comments = $request->custom_comments;
                $transaction->refill = $service->originalService->refill;
                $transaction->save();

                $userBalance = UserBalance::where('user_id', Auth::user()->id)
                    ->first();
                if($userBalance) {
                    $userBalance->balance = $userBalance->balance - round($subtotal);
                    $userBalance->save();
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to save transaction. '.$e->getMessage());
            }
            return redirect()->route('users.transactions.index')->with('success', 'Order processed successfully');
        }catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    public function storeTransactionMass(Request $request)
    {
        $setting = WebsiteSetting::first();
        try{
            $validatedData = $request->validate([
                'digital_platform_id' => 'required|exists:digital_platforms,id',
                'interaction_type_id' => 'required|exists:interaction_types,id',
                'service_id' => 'required|exists:primary_services,id',
                'target_link' => 'required|array',
                'target_link.*' => 'required|url',
                'quantity' => 'required|array',
                'quantity.*' => 'required|integer|min:1',
                'comments' => 'nullable|array',
                'total_price' => 'required|array',
                'total_price.*' => 'required|string',
            ]);

            foreach ($validatedData['target_link'] as $index => $targetLink) {
                $service = PrimaryService::find($request->service_id);
                if (!$service) {
                    continue;
                }
    
                $userBalance = UserBalance::where('user_id', Auth::user()->id)
                        ->first();
                if(!$userBalance) {
                    continue;
                }
    
                $subtotal = ($validatedData['quantity'][$index] / 1000) * $service->price;
    
                if($subtotal > $userBalance->balance) {
                    continue;
                }
                try {
                    if($service->type = "Default") {
                        $response = Http::asForm()->post($setting->irvan_url.'/order', [
                            'api_id'   => $setting->irvan_app_id,
                            'api_key'  => $setting->irvan_app_key,
                            'service'  => $service->originalService->service_code,
                            'target'   => $targetLink,
                            'quantity' => $validatedData['quantity'][$index],
                            'comments' => $validatedData['comments'][$index] ?? null,
                        ]);
                    }else if($service->type == 'Custom Comments') {
                        $response = Http::asForm()->post($setting->irvan_url.'/order', [
                            'api_id'   => $setting->irvan_app_id,
                            'api_key'  => $setting->irvan_app_key,
                            'service'  => $service->originalService->service_code,
                            'target'   => $targetLink,
                            'comments' => $validatedData['comments'][$index] ?? null,
                        ]);
                        
                    }
                } catch (\Exception $e) {
                    continue;
                }
            
                if ($response->failed()) {
                    continue;
                }

                $orderId = data_get($response->json(), 'data.id');
                if (!$orderId) {
                    return redirect()->back()->with('error', 'Invalid response from API.');
                }
            
                try {
                    $responseCheckOrder = Http::asForm()->post($setting->irvan_url.'/status', [
                        'api_id'   => $setting->irvan_app_id,
                        'api_key'  => $setting->irvan_app_key,
                        'id'       => $orderId,
                    ]);
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Failed to check order status.');
                }
            
                if ($responseCheckOrder->failed()) {
                    return redirect()->back()->with('error', 'Failed to check order status.');
                }
            
                $startCount = data_get($responseCheckOrder->json(), 'data.start_count');
                $remainingAmount = data_get($responseCheckOrder->json(), 'data.remains');

                $transaction = new TransactionService();
                $transaction->user_id = Auth::user()->id;
                $transaction->primary_service_id = $validatedData['service_id'];
                $transaction->digital_platform_id = $validatedData['digital_platform_id'];
                $transaction->interaction_type_id = $validatedData['interaction_type_id'];
                $transaction->trx_code = $orderId;
                $transaction->name = $service->name;
                $transaction->category = $service->originalService->category;
                $transaction->type = $service->originalService->type;
                $transaction->price = $service->price;
                $transaction->refill = $service->refill;
                $transaction->qty = $validatedData['quantity'][$index];
                $transaction->start_count = $startCount;
                $transaction->remains = $remainingAmount;
                $transaction->status = 'process';
                $transaction->target_link = $targetLink;
                $transaction->total = round($subtotal);
                $transaction->comments = $validatedData['comments'][$index] ?? null;
                $transaction->refill = $service->originalService->refill;
                $transaction->save();

                $userBalance = UserBalance::where('user_id', Auth::user()->id)
                    ->first();
                if($userBalance) {
                    $userBalance->balance = $userBalance->balance - round($subtotal);
                    $userBalance->save();
                }
            }
            return redirect()->route('users.transactions.index')->with('success', 'Mass Order processed successfully');
        }catch(\Exception $e) {
            return $e->getMessage();
        }
    }
    
}
