<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::paginate(10);
        return view('payments.index', compact('payments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Bank,E-Wallet,Other',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('payment-icons', 'public');
        }

        Payment::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'icon' => $iconPath,
        ]);

        return redirect()->back()->with('success', 'Payment method added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:Bank,E-Wallet,Other',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $payment = Payment::findOrFail($id);

        if ($request->hasFile('icon')) {
            if ($payment->icon) {
                Storage::disk('public')->delete($payment->icon);
            }
            $iconPath = $request->file('icon')->store('payment-icons', 'public');
        } else {
            $iconPath = $payment->icon;
        }

        $payment->update([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'icon' => $iconPath,
        ]);

        return redirect()->back()->with('success', 'Payment method updated successfully.');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        if ($payment->icon) {
            Storage::disk('public')->delete($payment->icon);
        }
        $payment->delete();
        return redirect()->back()->with('success', 'Payment method deleted successfully.');
    }
}
