@extends('layouts.app')
@section('title', 'Transaction Deposit')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Transaction Deposit</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="GET" action="{{ route('transactions.deposits.index') }}">
                    <div class="card-header border-bottom border-light">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="row justify-content-between g-3">
                            <div class="col-lg-6">
                                <div class="row g-3">
                                    <!-- Search Input -->
                                    <div class="col-lg-4">
                                        <div class="position-relative">
                                            <input type="text" name="search" value="{{ request('search') }}"
                                                class="form-control ps-4" placeholder="Search Order">
                                            <i class="ti ti-search position-absolute top-50 translate-middle-y ms-2"></i>
                                        </div>
                                    </div>

                                    <!-- Status Select -->
                                    <div class="col-lg-4">
                                        <div class="flex-grow-1 d-flex align-items-center">
                                            <label for="status-select" class="me-2">Status</label>
                                            <div class="flex-grow-1">
                                                <select class="form-select" id="status-select" name="status">
                                                    <option value="All"
                                                        {{ request('status') == 'All' ? 'selected' : '' }}>All</option>
                                                    <option value="pending"
                                                        {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                                    </option>
                                                    <option value="process"
                                                        {{ request('status') == 'process' ? 'selected' : '' }}>Processing
                                                    </option>
                                                    <option value="approved"
                                                        {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                                                    </option>
                                                    <option value="rejected"
                                                        {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Date Range Picker -->
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <input type="text" name="date_range" class="form-control flatpickr-input"
                                                value="{{ request('date_range') }}" data-provider="flatpickr"
                                                placeholder="Select Date Range" data-range-date="true" readonly>
                                            <span class="input-group-text bg-primary border-primary text-white">
                                                <i class="ti ti-calendar fs-15"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Filter Button -->
                            <div class="col-lg-6">
                                <div class="text-md-end mt-3 mt-md-0">
                                    <button type="submit" class="btn btn-dark waves-effect waves-light">
                                        <i class="ti ti-filter me-1"></i> Apply Filters
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th>#</th>
                                <th>Created At</th>
                                <th>Account Name</th>
                                <th>Account Number</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Transfer Proof</th>
                                <th>Action</th> <!-- New Action column -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($depositTransactions as $transaction)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->locale('id')->translatedFormat('d F Y H:i') }}
                                    </td>
                                    <td>{{ $transaction->paymentAccount->account_name }}</td>
                                    <td>{{ $transaction->paymentAccount->account_number }}</td>
                                    <td>{{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($transaction->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($transaction->status == 'process')
                                            <span class="badge bg-info">Processing</span>
                                        @elseif($transaction->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($transaction->status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($transaction->transfer_proof)
                                            <a href="{{ asset('storage/' . $transaction->transfer_proof) }}"
                                                target="_blank">View Proof</a>
                                        @else
                                            <span>No proof uploaded</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($transaction->status == 'pending')
                                            <!-- Approve button -->
                                            <form action="{{ route('transactions.deposits.approve', $transaction->id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                            </form>
                                            <!-- Reject button -->
                                            <form action="{{ route('transactions.deposits.rejected', $transaction->id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        @else
                                            <span>N/A</span>
                                        @endif
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
