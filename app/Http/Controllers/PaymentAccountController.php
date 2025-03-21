<?php

namespace App\Http\Controllers;

use App\Models\PaymentAccount;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentAccountController extends Controller
{
    public function index()
    {
        $paymentAccounts = PaymentAccount::with('payment')->get();
        $payments = Payment::all();
        return view('payment_accounts.index', compact('paymentAccounts', 'payments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        PaymentAccount::create($validated);

        return redirect()->route('payment_accounts.index')->with('success', 'Payment Account added successfully!');
    }

    public function edit($id)
    {
        $paymentAccount = PaymentAccount::findOrFail($id);
        $payments = Payment::all();
        return view('payment_accounts.edit', compact('paymentAccount', 'payments'));
    }

    public function update(Request $request, $id)
    {
        $paymentAccount = PaymentAccount::findOrFail($id);

        $validated = $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $paymentAccount->update($validated);

        return redirect()->route('payment_accounts.index')->with('success', 'Payment Account updated successfully!');
    }

    public function destroy($id)
    {
        $paymentAccount = PaymentAccount::findOrFail($id);
        $paymentAccount->delete();

        return redirect()->route('payment_accounts.index')->with('success', 'Payment Account deleted successfully!');
    }
}
