<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PaymentChannel;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentAccount;
use App\Models\TransactionDeposit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class UserDepositController extends Controller
{
    public function index(Request $request)
    {
        $depositTransactions = TransactionDeposit::where('user_id', Auth::user()->id)
            ->paginate(25);

        return view('users.deposit.index', compact('depositTransactions'));
    }

    public function create($a)
    {
        $channel = PaymentChannel::where('id', $a)
            ->first();
        
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
        try {
            // Cek apakah ada transaksi pending untuk user ini
            $pendingTransaction = TransactionDeposit::where('user_id', Auth::user()->id)
                ->where('status', 'pending')
                ->first();
    
            if ($pendingTransaction) {
                return redirect()->back()->with(['error' => 'Anda masih memiliki transaksi deposit yang belum selesai. Harap selesaikan sebelum mengajukan deposit baru.']);
            }
    
            // Validasi request
            $request->validate([
                'payment_channel_id' => 'required|exists:payment_channels,id',
                'amount' => 'required|numeric|min:50000|max:10000000',
            ]);
    
            // Variabel API iPaymu
            $va = '1179000899'; // Dapatkan dari dashboard iPaymu
            $apiKey = 'QbGcoO0Qds9sQFDmY0MWg1Tq.xtuh1'; // Dapatkan dari dashboard iPaymu
            $url = 'https://sandbox.ipaymu.com/api/v2/payment/direct'; // Untuk mode sandbox
            $referenceId = uniqid(); // Generate unique reference ID
    
            // Request Body untuk iPaymu
            $body = [
                'name' => trim(Auth::user()->full_name),
                'phone' => '085229931237',
                'email' => trim(Auth::user()->email),
                'amount' => floatval($request->amount),
                'notifyUrl' => trim('https://your-website.com/callback-url'),
                'referenceId' => $referenceId,
                'paymentMethod' => trim("qris"),
                'paymentChannel' => trim("mpa"),
            ];
    
            // Generate Signature
            $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
            $requestBody = strtolower(hash('sha256', $jsonBody));
            $stringToSign = strtoupper('POST') . ':' . $va . ':' . $requestBody . ':' . $apiKey;
            $signature = hash_hmac('sha256', $stringToSign, $apiKey);
            $timestamp = now()->format('YmdHis');
    
            // Request header untuk iPaymu
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'va' => $va,
                'signature' => $signature,
                'timestamp' => $timestamp,
            ];
    
            $response = Http::withHeaders($headers)->post($url, $body);
    
            if ($response->failed()) {
                return redirect()->back()->with(['error' => 'Gagal memproses pembayaran: ' . $response->body()]);
            }
    
            $responseData = $response->json()['Data'];
            $transaction = TransactionDeposit::create([
                'user_id' => Auth::user()->id,
                'payment_channel_id' => $request->payment_channel_id,
                'session_id' => $responseData['SessionId'],
                'transaction_id' => $responseData['TransactionId'],
                'reference_id' => $referenceId,
                'via' => $responseData['Via'],
                'channel' => $responseData['Channel'],
                'payment_no' => $responseData['PaymentNo'],
                'qr_string' => isset($responseData['qr_string']) ? $responseData['qr_string'] : '-',
                'payment_name' => $responseData['PaymentName'],
                'subtotal' => $responseData['SubTotal'],
                'fee' => $responseData['Fee'],
                'total' => $responseData['Total'],
                'fee_direction' => $responseData['FeeDirection'],
                'expired' => $responseData['Expired'],
                'qr_image' => isset($responseData['QrImage']) ? $responseData['QrImage'] : '-',
                'qr_template' => isset($responseData['QrTemplate']) ? $responseData['QrTemplate'] : '-',
                'status' => 'pending',
            ]);
    
            return redirect()->route('user.deposit.detail', $transaction->id)->with('success', 'Deposit berhasil diajukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Terjadi kesalahan saat mengajukan deposit: ' . $e->getMessage()]);
        }
    }

    public function detail($a)
    {
        $transactionDeposit = TransactionDeposit::where('id', $a)
            ->first();
        return view('users.deposit.detail', compact('transactionDeposit'));
    }
    
    
}
