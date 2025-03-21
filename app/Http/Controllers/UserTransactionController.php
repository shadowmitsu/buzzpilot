<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
        $categories = Category::where('status', 1)->get();
        $services = Service::where('status', 1)->get(); 
        return view('users.transactions.create', compact('categories', 'services'));
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
                'category_id' => 'required|exists:categories,id',
                'service_id'  => 'required|exists:services,id',
                'target_link' => 'required|url',
                'quantity'    => 'required|integer|min:1',
            ]);
        
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        
            $category = Category::find($request->category_id);
            if (!$category) {
                return redirect()->back()->with('error', 'Category not found');
            }
        
            $service = Service::find($request->service_id);
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
                        'service'  => $service->service_code,
                        'target'   => $request->target_link,
                        'quantity' => $request->quantity,
                        'comments' => $request->custom_comments,
                    ]);
                }else if($service->type == 'Custom Comments') {
                    $response = Http::asForm()->post($setting->irvan_url.'/order', [
                        'api_id'   => $setting->irvan_app_id,
                        'api_key'  => $setting->irvan_app_key,
                        'service'  => $service->service_code,
                        'target'   => $request->target_link,
                        'comments' => $request->custom_comments,
                    ]);
                    
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to connect to external service.');
            }
        
            if ($response->failed()) {
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
                $transaction->category_id = $request->category_id;
                $transaction->user_id = Auth::user()->id;
                $transaction->trx_id = $orderId;
                $transaction->name = $service->name;
                $transaction->type = $service->type;
                $transaction->price = $service->price;
                $transaction->refill = $service->refill;
                $transaction->qty = $request->quantity;
                $transaction->amount_before = $startCount;
                $transaction->remaining_amount = $remainingAmount;
                $transaction->status = 'process';
                $transaction->link_target = $request->target_link;
                $transaction->subtotal = round($subtotal);
                $transaction->comment = $request->custom_comments;
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
    
}
