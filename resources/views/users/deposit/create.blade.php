@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <h4 class="card-title m-0"><i class="mdi mdi-wallet-plus me-1"></i> Deposit</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.deposit.storeDeposit') }}" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="payment_channel_id" value="{{ $channel->id }}">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{ $channel->logo }}" width="50px"
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
                        <div class="row">
                            <div class="col-md">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Deposit</label>
                                    <div class="input-group ">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control " name="amount" maxlength="13">
                                    </div>
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
@endsection
