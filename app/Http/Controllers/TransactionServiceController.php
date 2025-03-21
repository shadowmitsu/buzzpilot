<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TransactionService;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransactionServiceController extends Controller
{
    public function index(Request $request)
    {
        $setting = WebsiteSetting::first();
        $transactionProcess = TransactionService::where('status', 'process')    
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

        $transactionServices = TransactionService::paginate(25);

        return view('service_transactions.index', compact('transactionServices'));
    }
}
