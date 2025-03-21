<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentChannel;
use App\Models\Service;
use App\Models\TransactionDeposit;
use App\Models\TransactionService;
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
            $totalDeposit = TransactionDeposit::sum('amount');
            $countUser = User::where('role', 'user')
                ->count();

            $transactionServices = TransactionService::where('status', 'process')
                ->paginate(25);
            return view('dashboard.superadmin', compact('balance', 'countTransactionService', 'totalDeposit', 'countUser', 'transactionServices'));
        }else if($user->role == 'operator') {
            return view('dashboard.operator');
        }else{
            $youtube = Service::where('status', 1)
                        ->where('name', 'LIKE', '%Youtube%')
                        ->take(10)
                        ->get();

            $instagram = Service::where('status', 1)
                        ->where('name', 'LIKE', '%Instagram%')
                        ->take(10)
                        ->get();

            $tiktok = Service::where('status', 1)
                        ->where('name', 'LIKE', '%Tiktok%')
                        ->take(10)
                        ->get();

            $twitter = Service::where('status', 1)
                        ->where('name', 'LIKE', '%Twitter%')
                        ->take(10)
                        ->get();

            $services = $youtube->merge($instagram)->merge($tiktok)->merge($twitter);

            $subtotalThisMonth = TransactionService::where('user_id', Auth::user()->id)
                ->sum('subtotal');

            return view('dashboard.user', compact('services', 'subtotalThisMonth'));

        }
    }
}
