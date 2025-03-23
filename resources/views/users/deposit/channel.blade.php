@extends('layouts.app')
@section('title', 'TopUp')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Deposit</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title m-0"><i class="mdi mdi-wallet-plus me-1"></i> QRIS</h4>
                </div>
                <div class="card-body">
                    <h6>QR Code</h6>
                    <div class="row">
                        @foreach ($qris as $qr)
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{ $qr->icon_url }}" width="50px" alt="{{ $qr->name }}">
                                            <div class="ps-3">
                                                <a href="{{ route('user.deposit.create', $qr->id) }}"
                                                    class="stretched-link text-dark">
                                                    <h6 class="mb-1">{{ $qr->name }}</h6>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="bg-success small p-1 text-center text-light rounded">
                                            Online [24 Jam]
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title m-0"><i class="mdi mdi-wallet-plus me-1"></i> Virtual Account</h4>
                </div>
                <div class="card-body">
                    <h6>Virtual Account</h6>
                    <div class="row">
                        @foreach ($va as $vab)
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{ $vab->icon_url }}" width="50px" alt="{{ $vab->name }}">
                                            <div class="ps-3">
                                                <a href="{{ route('user.deposit.create', $vab->id) }}"
                                                    class="stretched-link text-dark">
                                                    <h6 class="mb-1">{{ $vab->name }}</h6>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="bg-success small p-1 text-center text-light rounded">
                                            Online [24 Jam]
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
