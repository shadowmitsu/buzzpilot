@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Ticket #{{ $ticket->ticket_no }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h4 class="card-title m-0">
                        <i class="mdi mdi-information-variant me-1"></i> Ticket Information
                    </h4>
                </div>
                <div class="card-body">
                    <div class="mb-3 border-bottom pb-2">
                        <h6 class="fw-bold text-muted">ID Tiket</h6>
                        <p class="mb-0">#{{ $ticket->ticket_no }}</p>
                    </div>
        
                    <div class="mb-3 border-bottom pb-2">
                        <h6 class="fw-bold text-muted">Subjek</h6>
                        <p class="mb-0">{{ $ticket->subject }}</p>
                    </div>
        
                    <div class="mb-3 border-bottom pb-2">
                        <h6 class="fw-bold text-muted">Status</h6>
                        <span class="badge 
                            @if($ticket->status == 'open') bg-warning 
                            @elseif($ticket->status == 'in_progress') bg-primary 
                            @else bg-success @endif">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </div>
        
                    <div class="mb-3 border-bottom pb-2">
                        <h6 class="fw-bold text-muted">Dikirim pada</h6>
                        <p class="mb-0">{{ $ticket->created_at->format('d M Y H:i:s') }}</p>
                    </div>
        
                    <div class="pt-3">
                        <h6 class="fw-bold text-muted">Pembaruan Terakhir</h6>
                        <p class="mb-0">{{ $ticket->updated_at->format('d M Y H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md order-md-first">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title m-0"><i class="mdi mdi-message-text-outline me-1"></i> Replay Ticket</h4>
                </div>
                <div class="card-body">
                    <div id="ticketBox" style="max-height: 400px; overflow: auto" class="mb-3 pe-3">
                        @foreach($ticket->messages as $message)
                            @if($message->sender_id == auth()->id())
                                <div class="d-flex mb-3 flex-row-reverse">
                                    <img src="https://irvankedesmm.co.id/assets/images/user-icon.png" width="40px" height="40px" alt="">
                                    <div class="bg-dark text-light p-3 me-2 rounded" style="min-width: 50%; max-width: 80%;">
                                        <h6 class="fw-medium mb-3 text-light">
                                            {{ $message->sender->name }}
                                            <span class="float-end fw-normal">{{ $message->created_at->format('d M Y H:i:s') }}</span>
                                        </h6>
                                        {{ $message->message }}
                                    </div>
                                </div>
                            @else
                                <div class="d-flex mb-3">
                                    <img src="https://irvankedesmm.co.id/assets/images/user-icon.png" width="40px" height="40px" alt="">
                                    <div class="bg-dark text-light p-3 ms-2 rounded" style="min-width: 50%; max-width: 80%;">
                                        <h6 class="fw-medium mb-3 text-light">
                                            {{ $message->sender->name }}
                                            <span class="float-end fw-normal">{{ $message->created_at->format('d M Y H:i:s') }}</span>
                                        </h6>
                                        {{ $message->message }}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                    <form action="{{ route('users.ticket.sendmessage', $ticket->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="message" class="form-control " rows="5"></textarea>
                        </div>
                        <button type="submit" class="btn w-100 btn-primary">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
