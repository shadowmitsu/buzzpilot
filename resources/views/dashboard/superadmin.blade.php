@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Dashboard</h4>
                </div>
                {{-- <div class="mt-3 mt-sm-0">
                    <form action="javascript:void(0);">
                        <div class="row g-2 mb-0 align-items-center">
                            <div class="col-sm-auto">
                                <div class="input-group">
                                    <input type="text" class="form-control flatpickr-input" data-provider="flatpickr"
                                        data-deafult-date="01 May to 31 May" data-date-format="d M" data-range-date="true"
                                        readonly="readonly">
                                    <span class="input-group-text bg-primary border-primary text-white">
                                        <i class="ti ti-calendar fs-15"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> --}}
            </div>
        </div>
    </div>

    <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1 text-center">
        <!-- Total Orders -->
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-muted fs-13 text-uppercase" title="Total Orders">Balance</h5>
                    <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1">
                        <div class="user-img fs-42 flex-shrink-0">
                            <span class="avatar-title text-bg-primary rounded-circle fs-22">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-wallet">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
                                    <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
                                </svg>
                            </span>
                        </div>
                        <h3 class="mb-0 fw-bold">Rp {{ number_format($balance, 0, '.', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-muted fs-13 text-uppercase" title="Total Order Refills">Total Order</h5>
                    <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1">
                        <div class="user-img fs-42 flex-shrink-0">
                            <span class="avatar-title text-bg-primary rounded-circle fs-22">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-arrows-sort">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 9l4 -4l4 4m-4 -4v14" />
                                    <path d="M21 15l-4 4l-4 -4m4 4v-14" />
                                </svg>
                            </span>
                        </div>
                        <h3 class="mb-0 fw-bold">{{ number_format($countTransactionService, 0, '.', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-muted fs-13 text-uppercase" title="Total Deposits">Total Deposits</h5>
                    <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1">
                        <div class="user-img fs-42 flex-shrink-0">
                            <span class="avatar-title text-bg-primary rounded-circle fs-22">
                                <iconify-icon icon="carbon:wallet"></iconify-icon>
                            </span>
                        </div>
                        <h3 class="mb-0 fw-bold">Rp {{ number_format($totalDeposit, 0, '.', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="text-muted fs-13 text-uppercase" title="Total Users">Total Users</h5>
                    <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1">
                        <div class="user-img fs-42 flex-shrink-0">
                            <span class="avatar-title text-bg-primary rounded-circle fs-22">
                                <iconify-icon icon="mdi:account-multiple"></iconify-icon>
                            </span>
                        </div>
                        <h3 class="mb-0 fw-bold">{{ number_format($countUser, 0, '.', '.') }}</h3>
                    </div>
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
                            <h4 class="title">Order Process</h4>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th>#</th>
                                <th>trx ID</th>
                                <th>Created At</th>
                                <th>Service Name</th>
                                <th>Link Target</th>
                                <th>Qty</th>
                                <th>Biaya</th>
                                <th>Jml Awal</th>
                                <th>Sisa</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactionServices as $trs)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $trs->trx_id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($trs->created_at)->locale('id')->translatedFormat('d F Y H:i') }}
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($trs->name, 40) }}</td>
                                    <td>
                                        <span
                                            id="link{{ $loop->iteration }}">{{ \Illuminate\Support\Str::limit($trs->link_target, 40) }}</span>
                                        <button class="btn btn-sm btn-outline-primary"
                                            onclick="copyToClipboard('link{{ $loop->iteration }}')">Copy</button>
                                    </td>

                                    <td>{{ $trs->qty }}</td>
                                    <td>{{ number_format($trs->subtotal, 0, ',', '.') }}</td>
                                    <td>{{ $trs->amount_before }}</td>
                                    <td>{{ $trs->remaining_amount }}</td>
                                    <td>{{ $trs->status == 'process' ? 'Processing' : 'Completed' }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editPaymentAccountModal">
                                            Edit
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Script untuk copy link -->
                    <script>
                        function copyToClipboard(elementId) {
                            var copyText = document.getElementById(elementId).textContent;
                            navigator.clipboard.writeText(copyText).then(function() {
                                alert("Link copied to clipboard");
                            }, function(err) {
                                alert("Failed to copy link: ", err);
                            });
                        }
                    </script>

                </div>
                <div class="card-footer d-flex align-items-center justify-content-end">
                    <ul class="pagination justify-content-center mb-0">
                        <!-- Previous Page Link -->
                        <li class="page-item {{ $transactionServices->onFirstPage() ? 'disabled' : '' }}">
                            <a href="{{ $transactionServices->previousPageUrl() }}" class="page-link"><i
                                    class="ti ti-chevrons-left"></i></a>
                        </li>
                        @for ($i = 1; $i <= 3; $i++)
                            @if ($i <= $transactionServices->lastPage())
                                <li class="page-item {{ $i == $transactionServices->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $transactionServices->url($i) }}"
                                        class="page-link">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor
                        @if ($transactionServices->currentPage() > 4)
                            <li class="page-item disabled"><a class="page-link">...</a></li>
                        @endif
                        @for ($i = max(4, $transactionServices->currentPage() - 1); $i <= min($transactionServices->lastPage() - 3, $transactionServices->currentPage() + 1); $i++)
                            <li class="page-item {{ $i == $transactionServices->currentPage() ? 'active' : '' }}">
                                <a href="{{ $transactionServices->url($i) }}" class="page-link">{{ $i }}</a>
                            </li>
                        @endfor
                        @if ($transactionServices->currentPage() < $transactionServices->lastPage() - 3)
                            <li class="page-item disabled"><a class="page-link">...</a></li>
                        @endif
                        @for ($i = $transactionServices->lastPage() - 2; $i <= $transactionServices->lastPage(); $i++)
                            @if ($i > 3)
                                <li class="page-item {{ $i == $transactionServices->currentPage() ? 'active' : '' }}">
                                    <a href="{{ $transactionServices->url($i) }}"
                                        class="page-link">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor
                        <li class="page-item {{ $transactionServices->hasMorePages() ? '' : 'disabled' }}">
                            <a href="{{ $transactionServices->nextPageUrl() }}" class="page-link"><i
                                    class="ti ti-chevrons-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
