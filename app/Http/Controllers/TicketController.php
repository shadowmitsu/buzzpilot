<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::paginate(25);
        return view('tickets.index', compact('tickets'));
    }

    public function detail($a)
    {
        $ticket = Ticket::with('messages.sender')->findOrFail($a);
        return view('tickets.detail', compact('ticket'));
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{

            $store = new Ticket();
            $store->user_id = Auth::user()->id;
            $store->subject = $request->subject;
            $store->ticket_no = time();
            $store->status = 'open';
            $store->save();
            $store->fresh();

            $message = new TicketMessage();
            $message->ticket_id = $store->id;
            $message->sender_id = Auth::user()->id;
            $message->message = $request->message;
            $message->save();

            DB::commit();
            return redirect()->back()->with('success', 'Success create ticket.');
        }catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Sorry can`t create ticket, internal server error. '.$e->getMessage());
        }
    }

    public function sendMessage(Request $request, $a)
    {
        DB::commit();
        try{

            $store = new TicketMessage();
            $store->ticket_id = $a;
            $store->sender_id = Auth::user()->id;
            $store->message = $request->message;
            $store->save();
            
            DB::commit();
            return redirect()->back();

        }catch(\Exception $e) {
            DB::rollback();
            return redirect()->back();
        }
    }
}
