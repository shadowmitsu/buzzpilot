<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentChannel;
use App\Models\Service;
use App\Models\TransactionDeposit;
use App\Models\TransactionService;
use App\Models\TransactionTopUp;
use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $setting = WebsiteSetting::first();
        $user = Auth::user();
        if($user->role == 'superadmin') {
            $balance = 0;
            try {
                $responseCheckOrder = Http::asForm()->post($setting->irvan_url.'/profile', [
                    'api_id'   => $setting->irvan_app_id,
                    'api_key'  => $setting->irvan_app_key,
                ]);
            } catch (\Exception $e) {
                $balance = 0;
            }
        
            if ($responseCheckOrder->failed()) {
                $balance = 0;
            }
        
            $balance = data_get($responseCheckOrder->json(), 'data.balance');    
            $countTransactionService = TransactionService::count();
            $totalDeposit = TransactionTopUp::sum('amount');
            $countUser = User::where('role', 'user')
                ->count();

            $transactionServices = TransactionService::orderBy('created_at', 'DESC')
                ->paginate(25);
            return view('dashboard.superadmin', compact('balance', 'countTransactionService', 'totalDeposit', 'countUser', 'transactionServices'));
        }else if($user->role == 'operator') {
            return view('dashboard.operator');
        }else{
            $services = [];
            $subtotalThisMonth = TransactionService::where('user_id', Auth::user()->id)
                ->count();
            return view('dashboard.user', compact('services', 'subtotalThisMonth'));

        }
    }

    public function getPaymentChannels()
    {
        $apiKey = 'g1LmlGe0j1Ah6BBomCLfjWZGdsy3Zx3MTGJiM3uN';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->get('https://tripay.co.id/api/merchant/payment-channel');

        
        if ($response->successful()) {
            $res = $response->json(); 
            foreach($res['data'] as $dt) {
                PaymentChannel::create([
                    'group' => $dt['group'],
                    'code' => $dt['code'],
                    'name' => $dt['name'],
                    'type' => $dt['type'],
                    'fee_merchant_flat' => $dt['fee_merchant']['flat'],
                    'fee_merchant_percent' => $dt['fee_merchant']['percent'],
                    'fee_customer_flat' => $dt['fee_customer']['flat'],
                    'fee_customer_percent' => $dt['fee_customer']['percent'],
                    'total_fee_flat' => $dt['total_fee']['flat'],
                    'total_fee_percent' => $dt['total_fee']['percent'],
                    'minimum_fee' => $dt['minimum_fee'],
                    'maximum_fee' => $dt['maximum_fee'],
                    'minimum_amount' => $dt['minimum_amount'],
                    'maximum_amount' => $dt['maximum_amount'],
                    'icon_url' => $dt['icon_url'],
                    'active' => $dt['active'],
                ]);
            }
        } else {
            return response()->json(['error' => 'Error in fetching data'], $response->status());
        }
    }
}
