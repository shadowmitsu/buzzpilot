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
                        <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2 align-middle"></i>
                            <strong>Gotcha!</strong>
                            Permintaan deposit berhasil dibuat.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <p>Segera lakukan pembayaran sebelum:</p>
                        <div class="card card-body p-3">
                            <h6 class="fw-medium">Batas Waktu Pembayaran</h6>
                            <h4 class="m-0 text-danger">{{ $transactionDeposit->expired }}</h4>
                        </div>
                        @if ($transactionDeposit->qr_template)
                            <div id="qrcode"></div>
                        @endif
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                var paymentNo = "{{ $transactionDeposit->payment_no }}";
                        
                                if (paymentNo) {
                                    var qrcode = new QRCode(document.getElementById("qrcode"), {
                                        text: paymentNo,
                                        width: 250, 
                                        height: 250, 
                                    });
                                }
                            });
                        </script>
                        <p>Silakan klik tombol di bawah untuk melakukan check status pembayaran.</p>
                        <a href="#" class="btn btn-success bg-gradient mx-1">
                            <i class="fa fa-fw fa-paper-plane me-1"></i>
                            Check Status Bayar
                        </a>
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
                                <h6 class="fw-medium">ID Deposit</h6>#{{ $transactionDeposit->reference_id }}
                            </div>
                            <div class="align-self-center">
                                Ada yang salah/tidak sesuai?
                                <a href="https://irvankedesmm.co.id/deposit/396739/cancel"
                                    class="btn btn-danger bg-gradient btn-sm mx-1"><i class="fa fa-fw fa-times me-1"></i>
                                    Batal</a>
                            </div>
                        </div>
                        <div class="border-bottom py-3">
                            <h6 class="fw-medium">Status</h6>
                            <div class="border-bottom py-3">
                                <h6 class="fw-medium">Status</h6>
                                @if ($transactionDeposit->status == 'pending')
                                    <span class="badge bg-warning bg-gradient">Belum Bayar</span>
                                @elseif($transactionDeposit->status == 'process')
                                    <span class="badge bg-info bg-gradient">Diproses</span>
                                @elseif($transactionDeposit->status == 'approved')
                                    <span class="badge bg-success bg-gradient">Disetujui</span>
                                @elseif($transactionDeposit->status == 'rejected')
                                    <span class="badge bg-danger bg-gradient">Ditolak</span>
                                @elseif($transactionDeposit->status == 'canceled')
                                    <span class="badge bg-secondary bg-gradient">Dibatalkan</span>
                                @endif
                            </div>

                        </div>
                        <div class="border-bottom py-3">
                            <h6 class="fw-medium">Dibuat</h6>{{ $transactionDeposit->created_at }}
                        </div>
                        <div class="border-bottom py-3">
                            <h6 class="fw-medium">Metode Pembayaran</h6> {{ $transactionDeposit->paymentChannel->name }}
                        </div>
                        <div class="border-bottom py-3">
                            <h6 class="fw-medium">Jumlah Deposit</h6>Rp
                            {{ number_format($transactionDeposit->subtotal, 0, '.', '.') }}
                        </div>
                        <div class="border-bottom py-3">
                            <h6 class="fw-medium">Total <small>*Jumlah yang harus dibayar</small></h6>
                            <h4 class="m-0 text-danger">Rp {{ number_format($transactionDeposit->total, 0, '.', '.') }}
                            </h4>
                        </div>
                        <div class="pt-3">
                            <h6 class="fw-medium">Saldo <small>*Jumlah saldo yang didapatkan</small></h6>
                            Rp {{ number_format($transactionDeposit->subtotal, 0, '.', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
