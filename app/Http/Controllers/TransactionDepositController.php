<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TransactionDeposit;
use App\Models\TransactionTopUp;
use App\Models\UserBalance;
use Illuminate\Http\Request;

class TransactionDepositController extends Controller
{
    public function index(Request $request)
    {
        $query = TransactionTopUp::query();

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('full_name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('username', 'LIKE', '%' . $request->search . '%');
            });
        }
    
        if ($request->has('status') && $request->status != 'All') {
            $query->where('paid_status', $request->status);
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
}
