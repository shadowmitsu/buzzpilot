@extends('layouts.app')
@section('title', 'Data Service Orders')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Transaction Services</h4>
                </div>
                <div>
                    <a href="{{ route('users.transactions.create') }}" class="btn btn-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#addPaymentAccountModal">
                        Create Order
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom border-light">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="row justify-content-between g-3">
                        <div class="col-lg-6">
                            <h4 class="title">Transaction Services</h4>
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
                                    <td>{{ $trs->trx_code }}</td>
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
                                    <td>{{ $trs->start_count }}</td>
                                    <td>{{ $trs->remains }}</td>
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
