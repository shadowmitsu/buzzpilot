@extends('layouts.app')
@section('title', 'Data Payment Accounts')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Payment Accounts</h4>
                </div>
                <div>
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPaymentAccountModal">
                        Add Payment Account
                    </button>
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
                            <h4 class="title">Payment Accounts</h4>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th>#</th>
                                <th>Payment Name</th>
                                <th>Account Number</th>
                                <th>Account Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paymentAccounts as $paymentAccount)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $paymentAccount->payment->name }}</td>
                                    <td>{{ $paymentAccount->account_number }}</td>
                                    <td>{{ $paymentAccount->account_name }}</td>
                                    <td>{{ $paymentAccount->is_active ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPaymentAccountModal"
                                            onclick="setEditModalData({{ $paymentAccount->id }}, '{{ $paymentAccount->account_number }}', '{{ $paymentAccount->account_name }}', {{ $paymentAccount->payment_id }}, {{ $paymentAccount->is_active }})">
                                            Edit
                                        </button>

                                        <form action="{{ route('payment_accounts.destroy', $paymentAccount->id) }}" method="POST"
                                              style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addPaymentAccountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Payment Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('payment_accounts.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="payment_id" class="form-label">Payment Method</label>
                            <select name="payment_id" class="form-control" required>
                                @foreach ($payments as $payment)
                                    <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="account_number" class="form-label">Account Number</label>
                            <input type="text" class="form-control" name="account_number" required>
                        </div>

                        <div class="mb-3">
                            <label for="account_name" class="form-label">Account Name</label>
                            <input type="text" class="form-control" name="account_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select name="is_active" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Payment Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editPaymentAccountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Payment Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editPaymentForm" action="" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="payment_id_edit" class="form-label">Payment Method</label>
                            <select name="payment_id" id="payment_id_edit" class="form-control" required>
                                @foreach ($payments as $payment)
                                    <option value="{{ $payment->id }}">{{ $payment->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="account_number_edit" class="form-label">Account Number</label>
                            <input type="text" id="account_number_edit" class="form-control" name="account_number" required>
                        </div>

                        <div class="mb-3">
                            <label for="account_name_edit" class="form-label">Account Name</label>
                            <input type="text" id="account_name_edit" class="form-control" name="account_name" required>
                        </div>

                        
                        <div class="mb-3">
                            <label for="is_active_edit" class="form-label">Status</label>
                            <select name="is_active" id="is_active_edit" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Payment Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setEditModalData(id, accountNumber, accountName, paymentId, isActive) {
            document.getElementById('account_number_edit').value = accountNumber;
            document.getElementById('account_name_edit').value = accountName;
            document.getElementById('payment_id_edit').value = paymentId;
            document.getElementById('is_active_edit').value = isActive;
            
            document.getElementById('editPaymentForm').action = `/payment-accounts/${id}/update`;
        }
    </script>
@endsection
