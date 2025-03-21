<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TransactionDeposit;
use App\Models\UserBalance;
use Illuminate\Http\Request;

class TransactionDepositController extends Controller
{
    public function index(Request $request)
    {
        $query = TransactionDeposit::query();

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('paymentAccount', function($q) use ($request) {
                $q->where('account_name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('account_number', 'LIKE', '%' . $request->search . '%');
            });
        }
    
        if ($request->has('status') && $request->status != 'All') {
            $query->where('status', $request->status);
        }
    
        if ($request->has('date_range') && $request->date_range != '') {
            $dates = explode(' to ', $request->date_range);
            $start = \Carbon\Carbon::createFromFormat('d M Y', $dates[0])->startOfDay();
            $end = \Carbon\Carbon::createFromFormat('d M Y', $dates[1])->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }
    
        $depositTransactions = $query->paginate(25);
    
        return view('deposit_transactions.index', compact('depositTransactions'));
    }

    public function approve($id)
    {
        $transaction = TransactionDeposit::findOrFail($id);
        if ($transaction->status === 'pending') {
            $transaction->status = 'approved';
            $transaction->save();

            $userBalance = UserBalance::where('user_id', $transaction->user_id)
                ->first();
            if($userBalance) {
                $userBalance->balance = $userBalance->balance = $transaction->amount;
                $userBalance->save();
            }
        }

        return redirect()->route('transactions.deposits.index')->with('success', 'Transaction approved successfully.');
    }
    public function reject($id)
    {
        $transaction = TransactionDeposit::findOrFail($id);
        if ($transaction->status === 'pending') {
            $transaction->status = 'rejected';
            $transaction->save();
        }

        return redirect()->route('transactions.deposits.index')->with('success', 'Transaction rejected successfully.');
    }
    
}
