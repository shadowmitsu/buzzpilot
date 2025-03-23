<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TransactionTopUp;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        $privateKey = 'aI8M5-8FLYp-BDYw9-KRm5P-x5pbg';
        $json = $request->getContent();
        $callbackSignature = $request->header('X-Callback-Signature');
        $signature = hash_hmac('sha256', $json, $privateKey);

        if ($callbackSignature !== $signature) {
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        $data = $request->all();

        if ($data['status'] === 'PAID') {
            try {
                $transaction = TransactionTopUp::where('reference', $data['reference'])
                    ->orWhere('merchant_ref', $data['merchant_ref'])
                    ->first();

                if (!$transaction) {
                    return response()->json(['error' => 'Transaction not found'], 404);
                }

                $transaction->update([
                    'status'          => $data['status'],
                ]);

                return response()->json(['success' => 'Transaction updated successfully'], 200);

            } catch (\Exception $e) {
                return response()->json(['error' => 'Internal server error'], 500);
            }
        }

        return response()->json(['message' => 'Callback received but status is not PAID'], 200);
    }
}
