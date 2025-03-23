@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title m-0"><i class="mdi mdi-information-variant me-1"></i> Informasi Pembayaran</h4>
                    </div>
                    <div class="card-body">
                        <p>Segera lakukan pembayaran sebelum:</p>
                        <div class="card card-body p-3">
                            <h6 class="fw-medium">Batas Waktu Pembayaran</h6>
                            <h4 class="m-0 text-danger">{{ $transactionDeposit->expired_time }}</h4>
                        </div>
                        @if ($transactionDeposit->status == 'UNPAID')
                            <p>Silakan klik tombol di bawah ini untuk melakukan pembayaran.</p>
                            <a href="{{ $transactionDeposit->checkout_url }}" class="btn btn-success bg-gradient mx-1"
                                target="_blank">
                                <i class="fa fa-fw fa-paper-plane me-1"></i>
                                Bayar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md order-md-first">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title m-0"><i class="mdi mdi-view-list me-1"></i> Detail Deposit #396739</h4>
                    </div>
                    <div class="card-body">
                        <div class="border-bottom pb-3 d-flex">
                            <div class="flex-grow-1">
                                <h6 class="fw-medium">ID Deposit</h6>#{{ $transactionDeposit->reference }}
                            </div>
                            {{-- @if ($transactionDeposit->paid_status == 'unpaid')     
                                <div class="align-self-center">
                                    Ada yang salah/tidak sesuai?
                                    <a href=""
                                        class="btn btn-danger bg-gradient btn-sm mx-1"><i class="fa fa-fw fa-times me-1"></i>
                                        Batal</a>
                                </div>
                            @endif --}}
                        </div>
                        <div class="border-bottom py-3">
                            <h6 class="fw-medium">Status</h6>
                            @if ($transactionDeposit->status == 'UNPAID')
                                <span class="badge bg-warning bg-gradient">Belum Bayar</span>
                            @elseif($transactionDeposit->status == 'PAID')
                                <span class="badge bg-success bg-gradient">Berhasil Melakukan Pembayaran</span>
                            @elseif($transactionDeposit->status == 'CANCELED')
                                <span class="badge bg-secondary bg-gradient">Dibatalkan</span>
                            @endif

                        </div>
                        <div class="border-bottom py-3">
                            <h6 class="fw-medium">Dibuat</h6>{{ $transactionDeposit->created_at }}
                        </div>
                        <div class="border-bottom py-3">
                            <h6 class="fw-medium">Metode Pembayaran</h6> {{ $transactionDeposit->paymentChannel->name }}
                        </div>
                        <div class="border-bottom py-3">
                            <h6 class="fw-medium">Jumlah Deposit</h6>Rp
                            {{ number_format($transactionDeposit->amount, 0, '.', '.') }}
                        </div>
                        <div class="border-bottom py-3">
                            <h6 class="fw-medium">Total <small>*Fee</small></h6>
                            <h4 class="m-0 text-danger">Rp {{ number_format($transactionDeposit->total_fee, 0, '.', '.') }}
                            </h4>
                        </div>
                        <div class="pt-3">
                            <h6 class="fw-medium">Saldo <small>*Jumlah saldo yang didapatkan</small></h6>
                            Rp {{ number_format($transactionDeposit->amount_received, 0, '.', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
