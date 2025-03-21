@extends('layouts.app')
@section('title', 'Data Payments')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Payment Providers</h4>
                </div>
                <div>
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                        Add Payment Method
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom border-light">
                    <h4 class="title">Payment Methods</h4>
                </div>

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Min Deposit</th>
                                <th>Max Deposit</th>
                                <th>Icon</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $payment->name }}</td>
                                    <td>{{ $payment->category }}</td>
                                    <td>{{ $payment->description }}</td>
                                    <td>{{ $payment->min_deposit }}</td>
                                    <td>{{ $payment->max_deposit }}</td>
                                    <td>
                                        @if ($payment->icon)
                                            <img src="{{ asset('storage/' . $payment->icon) }}" alt="icon" style="width: 50px;">
                                        @else
                                            No Icon
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPaymentModal{{ $payment->id }}">Edit</button>
                                        <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editPaymentModal{{ $payment->id }}" tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editPaymentModalLabel">Edit Payment Method</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('payments.update', $payment->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" class="form-control" name="name" value="{{ $payment->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="category" class="form-label">Category</label>
                                                        <select name="category" class="form-control" required>
                                                            <option value="Bank" {{ $payment->category == 'Bank' ? 'selected' : '' }}>Bank</option>
                                                            <option value="E-Wallet" {{ $payment->category == 'E-Wallet' ? 'selected' : '' }}>E-Wallet</option>
                                                            <option value="Other" {{ $payment->category == 'Other' ? 'selected' : '' }}>Other</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="description" class="form-label">Description</label>
                                                        <textarea name="description" class="form-control">{{ $payment->description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="min_deposit" class="form-label">Minimum Deposit</label>
                                                        <input type="number" class="form-control" name="min_deposit" value="{{ $payment->min_deposit }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="max_deposit" class="form-label">Maximum Deposit</label>
                                                        <input type="number" class="form-control" name="max_deposit" value="{{ $payment->max_deposit }}" required>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label for="icon" class="form-label">Icon</label>
                                                        <input type="file" name="icon" class="form-control">
                                                        @if ($payment->icon)
                                                            <img src="{{ asset('storage/' . $payment->icon) }}" alt="icon" style="width: 50px;" class="mt-2">
                                                        @endif
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer d-flex align-items-center justify-content-end">
                    <ul class="pagination justify-content-center mb-0">
                        <!-- Pagination links -->
                        <li class="page-item {{ $payments->onFirstPage() ? 'disabled' : '' }}">
                            <a href="{{ $payments->previousPageUrl() }}" class="page-link"><i class="ti ti-chevrons-left"></i></a>
                        </li>
                        @for ($i = 1; $i <= $payments->lastPage(); $i++)
                            <li class="page-item {{ $i == $payments->currentPage() ? 'active' : '' }}">
                                <a href="{{ $payments->url($i) }}" class="page-link">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="page-item {{ $payments->hasMorePages() ? '' : 'disabled' }}">
                            <a href="{{ $payments->nextPageUrl() }}" class="page-link"><i class="ti ti-chevrons-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentModalLabel">Add Payment Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" class="form-control" required>
                                <option value="Bank">Bank</option>
                                <option value="E-Wallet">E-Wallet</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="min_deposit" class="form-label">Minimum Deposit</label>
                            <input type="number" class="form-control" name="min_deposit" required>
                        </div>
                        <div class="mb-3">
                            <label for="max_deposit" class="form-label">Maximum Deposit</label>
                            <input type="number" class="form-control" name="max_deposit" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="icon" class="form-label">Icon</label>
                            <input type="file" name="icon" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
