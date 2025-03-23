@extends('layouts.app')
@section('title', 'Data History Topup')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Deposit Transactions</h4>
                </div>
                <div>
                    <a href="{{ route('user.deposit.channels') }}" class="btn btn-primary mb-3">
                        Topup
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom border-light">
                    <div class="row justify-content-between g-3">
                        <div class="col-lg-6">
                            <h4 class="title">Deposit Transactions</h4>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th>#</th>
                                <th>Created At</th>
                                <th>Payment</th>
                                <th>VIA</th>
                                <th>Amount</th>
                                <th>Fee</th>
                                <th>Status</th>
                                <th>Transfer Proof</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($depositTransactions as $transaction)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->locale('id')->translatedFormat('d F Y H:i') }}
                                    </td>
                                    <td>{{ $transaction->payment_method }}</td>
                                    <td>{{ $transaction->payment_name }}</td>
                                    <td>{{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                    <td>{{ number_format($transaction->fee_merchant, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($transaction->status == 'UNPAID')
                                            <span class="badge bg-warning">UNPAID</span>
                                        @elseif($transaction->status == 'CANCELED')
                                            <span class="badge bg-info">CANCELED</span>
                                        @elseif($transaction->status == 'PAID')
                                            <span class="badge bg-success">PAID</span>
                                        @elseif($transaction->status == 'EXPIRED')
                                            <span class="badge bg-danger">Expired</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($transaction->status == 'unpaid')
                                            <a href="{{ $transaction->checkout_url }}" target="_blank" class="btn btn-warning btn-sm">Pay Now</a>
                                        @endif
                                        <a href="{{ route('user.deposit.detail', $transaction->id) }}" class="btn btn-info btn-sm">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer d-flex align-items-center justify-content-end">
                    <ul class="pagination justify-content-center mb-0">
                        <!-- Previous Page Link -->
                        <li class="page-item {{ $depositTransactions->onFirstPage() ? 'disabled' : '' }}">
                            <a href="{{ $depositTransactions->previousPageUrl() }}" class="page-link"><i
                                    class="ti ti-chevrons-left"></i></a>
                        </li>
                        @for ($i = 1; $i <= 3; $i++)
                            @if ($i <= $depositTransactions->lastPage())
                                <li class="page-item {{ $i == $depositTransactions->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $depositTransactions->url($i) }}"
                                        class="page-link">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor
                        @if ($depositTransactions->currentPage() > 4)
                            <li class="page-item disabled"><a class="page-link">...</a></li>
                        @endif
                        @for ($i = max(4, $depositTransactions->currentPage() - 1); $i <= min($depositTransactions->lastPage() - 3, $depositTransactions->currentPage() + 1); $i++)
                            <li class="page-item {{ $i == $depositTransactions->currentPage() ? 'active' : '' }}">
                                <a href="{{ $depositTransactions->url($i) }}" class="page-link">{{ $i }}</a>
                            </li>
                        @endfor
                        @if ($depositTransactions->currentPage() < $depositTransactions->lastPage() - 3)
                            <li class="page-item disabled"><a class="page-link">...</a></li>
                        @endif
                        @for ($i = $depositTransactions->lastPage() - 2; $i <= $depositTransactions->lastPage(); $i++)
                            @if ($i > 3)
                                <li class="page-item {{ $i == $depositTransactions->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $depositTransactions->url($i) }}"
                                        class="page-link">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor
                        <li class="page-item {{ $depositTransactions->hasMorePages() ? '' : 'disabled' }}">
                            <a href="{{ $depositTransactions->nextPageUrl() }}" class="page-link"><i
                                    class="ti ti-chevrons-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
