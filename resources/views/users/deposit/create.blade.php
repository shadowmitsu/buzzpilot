@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-lg-7">
            <div class="card">

                <div class="card-header">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <h4 class="card-title m-0"><i class="mdi mdi-wallet-plus me-1"></i> Deposit</h4>
                </div>
                <div class="card-body">
                    <form id="depositForm" action="{{ route('user.deposit.storeDeposit') }}" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="payment_channel_id" value="{{ $channel->id }}">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{ $channel->icon_url }}" width="50px"
                                                alt="Qris By Danamon [NO FEE] [BONUS 15%]">
                                            <div class="ps-3">
                                                <h6 class="mb-1 text-dark">{{ $channel->name }}</h6>
                                            </div>
                                        </div>
                                        <div class="bg-success bg-gradient small p-1 text-center text-light rounded">
                                            Online [24 Jam]
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tampilkan catatan minimum dan maksimum top-up -->
                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Deposit</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control" id="amount" name="amount"
                                            maxlength="13">
                                    </div>
                                    <small class="form-text text-muted">
                                        <span id="minAmount" class="none">{{ $channel->minimum_deposit }}</span>
                                        <span id="maxAmount" class="none">{{ $channel->maximum_amount }}</span>
                                        Minimum: Rp <span>{{ number_format($channel->minimum_amount, 0, ',', '.') }}</span>,
                                        Maksimum: Rp <span>{{ number_format($channel->maximum_amount, 0, ',', '.') }}</span>
                                    </small>
                                    <div class="text-danger mt-1" id="amountError" style="display: none;">Jumlah deposit
                                        harus antara Rp <span id="minValue">{{ number_format($channel->minimum_amount, 0, ',', '.') }}</span> dan Rp
                                        <span id="maxValue">{{ number_format($channel->maximum_amount, 0, ',', '.') }}</span>.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('user.deposit.channels') }}"
                                        class="btn w-100 btn-secondary bg-gradient mb-3 mb-lg-0">
                                        Ganti Metode Pembayaran
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn w-100 btn-primary bg-gradient">
                                        Lanjutkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('depositForm').addEventListener('submit', function (e) {
            // Ambil nilai input
            var amount = parseFloat(document.getElementById('amount').value.replace(/,/g, ''));
            var minAmount = parseFloat(document.getElementById('minAmount').innerText);
            var maxAmount = parseFloat(document.getElementById('maxAmount').innerText);
            var errorElement = document.getElementById('amountError');
            
            if (isNaN(amount) || amount < minAmount || amount > maxAmount) {
                e.preventDefault();
                errorElement.style.display = 'block'; 
            } else {
                errorElement.style.display = 'none';
            }
        });
    </script>
    
@endsection
