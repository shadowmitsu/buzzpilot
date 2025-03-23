<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentChannel;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentAccount;
use App\Models\TransactionDeposit;
use App\Models\TransactionTopUp;
use App\Models\UserBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class UserDepositController extends Controller
{
    public function index(Request $request)
    {
        $depositTransactions = TransactionTopUp::where('user_id', Auth::user()->id)
            ->paginate(25);

        return view('users.deposit.index', compact('depositTransactions'));
    }

    public function create($a)
    {
        $channel = PaymentChannel::where('id', $a)
            ->first();
        $pendingTransaction = TransactionTopUp::where('user_id', Auth::user()->id)
            ->where('status', 'unpaid')
            ->first();

        if ($pendingTransaction) {
            return redirect()->back()->with(['error' => 'Anda masih memiliki transaksi deposit yang belum selesai. Harap selesaikan sebelum mengajukan deposit baru.']);
        }
        return view('users.deposit.create', compact('channel'));
    }
    
    
    public function channels()
    {
        $qris = PaymentChannel::where('name', 'Like', '%qris%')
            ->get();
        
        $va = PaymentChannel::whereNot('name', 'Like', '%qris%')
            ->get();
        
        return view('users.deposit.channel', compact('qris', 'va'));
    }

    public function storeDeposit(Request $request)
    {
        $paymentChannel = PaymentChannel::where('id', $request->payment_channel_id)
            ->first();
        $apiKey       = 'g1LmlGe0j1Ah6BBomCLfjWZGdsy3Zx3MTGJiM3uN';
        $privateKey   = 'aI8M5-8FLYp-BDYw9-KRm5P-x5pbg';
        $merchantCode = 'T38493';
        $merchantRef  = 'INV'.time();
        $amount       = (int)$request->amount;
        
        try {
            $pendingTransaction = TransactionTopUp::where('user_id', Auth::user()->id)
                ->where('status', 'unpaid')
                ->first();

            if ($pendingTransaction) {
                return redirect()->back()->with(['error' => 'Anda masih memiliki transaksi deposit yang belum selesai. Harap selesaikan sebelum mengajukan deposit baru.']);
            }
    
            $data = [
                'method'         => $paymentChannel->code, 
                'merchant_ref'   => $merchantRef,
                'amount'         => $amount,
                'customer_name'  => 'Nama Pelanggan',
                'customer_email' => 'emailpelanggan@domain.com',
                'customer_phone' => '081234567890',
                'order_items'    => [
                    [
                        'sku'         => 'FB-06',
                        'name'        => 'Nama Produk 1',
                        'price'       => $amount,
                        'quantity'    => 1,
                        'product_url' => 'https://tokokamu.com/product/nama-produk-1',
                        'image_url'   => 'https://tokokamu.com/product/nama-produk-1.jpg',
                    ],
                ],
                'return_url'   => 'https://panel.buzzpilot.org/dashboard',
                'expired_time' => (time() + (24 * 60 * 60)),
                'signature'    => hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey)
            ];
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey
            ])->post('https://tripay.co.id/api/transaction/create', $data);
            $responseData = $response->json()['data'];
    
            TransactionTopUp::create([
                'user_id'            => Auth::user()->id,
                'payment_channel_id' => $request->payment_channel_id,
                'reference'          => $responseData['reference'], 
                'merchant_ref'       => $merchantRef,               
                'payment_method'     => $responseData['payment_method'], 
                'payment_name'       => $responseData['payment_name'],   
                'customer_name'      => $responseData['customer_name'],  
                'customer_email'     => $responseData['customer_email'], 
                'customer_phone'     => $responseData['customer_phone'], 
                'callback_url'       => 'https://panel.buzzpilot.org/callback/tripay',
                'return_url'         => 'https://panel.buzzpilot.org/dashboard',
                'amount'             => $amount,                     
                'fee_merchant'       => $responseData['fee_merchant'], 
                'fee_customer'       => $responseData['fee_customer'], 
                'total_fee'          => $responseData['total_fee'],     
                'amount_received'    => $responseData['amount_received'], 
                'pay_code'           => $responseData['pay_code'],    
                'pay_url'            => $responseData['pay_url'],     
                'checkout_url'       => $responseData['checkout_url'],
                'status'             => 'UNPAID', 
                'expired_time'       => date('Y-m-d H:i:s', $responseData['expired_time']), // Waktu kadaluarsa transaksi
            ]);

            return redirect($responseData['checkout_url']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Terjadi kesalahan saat mengajukan deposit: ' . $e->getMessage()]);
        }
    }
    
    public function detail($a)
    {
        $transactionDeposit = TransactionTopUp::where('id', $a)->first();
        if(!$transactionDeposit) {
            return redirect()->route('user.deposit.index');
        }
       
        $apiKey = 'g1LmlGe0j1Ah6BBomCLfjWZGdsy3Zx3MTGJiM3uN';

        $payload = [
            'reference' => $transactionDeposit->reference,
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
            ])->get('https://tripay.co.id/api/transaction/check-status', $payload);

            if ($response->successful()) {
                $responseData = $response->json();
                $transactionDeposit = TransactionTopUp::where('id', $a)->first();
                // return $responseData;
                if($responseData['message'] != 'Status transaksi belum sukses. Coba beberapa menit lagi') {
                    if ($transactionDeposit) {
                        $userBalance = UserBalance::where('user_id', $transactionDeposit->user_id)
                            ->first();
    
                        if($userBalance && $responseData['message'] == 'Status transaksi saat ini PAID') {
                            $newBalance = $responseData['Data']['Amount'] - $responseData['Data']['Fee'];
                            $userBalance->balance = $newBalance;
                            $userBalance->save();
                        }
        
                        $transactionDeposit->update([
                            'status' => $responseData['message'] == 'Status transaksi saat ini PAID' ? 'PAID' : strtoupper($transactionDeposit->status)
                        ]);
                    }
        
                }
                return view('users.deposit.detail', compact('transactionDeposit'));
            } else {
                return redirect()->route('user.deposit.index');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            return redirect()->route('user.deposit.index');
        }
    }
    
    
}
