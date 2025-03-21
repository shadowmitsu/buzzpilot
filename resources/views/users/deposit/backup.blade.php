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
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="card-title mb-0 fw-semibold text-uppercase">Form Deposit :</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.deposit.storeDeposit') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-2">
                            <label for="payment_id">Metode Pembayaran</label>
                            <select name="payment_id" id="payment_id" class="form-control" required
                                onchange="updatePaymentDetails()">
                                <option value="">Pilih Metode Pembayaran</option>
                                @foreach ($payments as $payment)
                                    <option value="{{ $payment->id }}" data-min="{{ $payment->min_deposit }}"
                                        data-max="{{ $payment->max_deposit }}">
                                        {{ $payment->name }} ({{ $payment->category }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Detail akun pembayaran dan min/max deposit akan muncul di sini -->
                        <div id="paymentDetails" style="display: none;">
                            <input type="hidden" id="payment_account_id" name="payment_account_id" value="">
                            <div class="form-group mb-2">
                                <label>Nomor Rekening</label>
                                <div class="input-group">
                                    <input type="text" id="accountNumber" class="form-control" readonly>
                                    <button type="button" class="btn btn-secondary"
                                        onclick="copyToClipboard()">Salin</button>
                                </div>
                            </div>

                            <div class="form-group mb-1">
                                <label>Nama Pemilik Akun</label>
                                <input type="text" id="accountName" class="form-control" readonly>
                            </div>

                            <div class="form-group mb-1">
                                <label>Batas Minimum dan Maksimum Deposit</label>
                                <p id="depositLimits"></p>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label for="amount">Jumlah Deposit</label>
                            <input type="number" name="amount" id="amount" class="form-control" required min="50000"
                                max="10000000">
                        </div>

                        <div class="form-group mb-2">
                            <label for="transfer_proof">Bukti Transfer (Opsional)</label>
                            <input type="file" name="transfer_proof" id="transfer_proof" class="form-control">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Deposit</button>
                        </div>
                    </form>

                    <script>
                        function updatePaymentDetails() {
                            const paymentId = document.getElementById('payment_id').value;
                            const paymentSelect = document.getElementById('payment_id');
                            const selectedOption = paymentSelect.options[paymentSelect.selectedIndex];
                            const minDeposit = selectedOption.getAttribute('data-min');
                            const maxDeposit = selectedOption.getAttribute('data-max');

                            // Ambil akun pembayaran terkait dari backend (ganti dengan ajax jika perlu)
                            fetch(`/get-payment-account/${paymentId}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.account) {
                                        document.getElementById('accountNumber').value = data.account.account_number;
                                        document.getElementById('accountName').value = data.account.account_name;
                                        document.getElementById('depositLimits').innerText = `Min: ${minDeposit}, Max: ${maxDeposit}`;
                                        document.getElementById('paymentDetails').style.display = 'block';
                                        document.getElementById('payment_account_id').value = data.account.id;
                                        document.getElementById('amount').min = minDeposit;
                                        document.getElementById('amount').max = maxDeposit;
                                    }
                                });
                        }

                        function copyToClipboard() {
                            const accountNumberField = document.getElementById('accountNumber');
                            accountNumberField.select();
                            document.execCommand('copy');
                            alert('Nomor rekening berhasil disalin!');
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
