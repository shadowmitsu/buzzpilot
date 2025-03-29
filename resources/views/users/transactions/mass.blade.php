@extends('layouts.app')
@section('title', 'Create Order')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 text-uppercase fw-bold m-0">Create Transaction</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header border-bottom border-dashed">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <h4 class="card-title">Formulir Buat Pesanan Layanan Boost Social Media</h4>
                    <p class="text-muted mb-0">Informasi layanan ini mencakup semua data terkait layanan yang kami tawarkan
                        untuk meningkatkan jangkauan dan interaksi akun media sosial seperti YouTube, Instagram, TikTok, dan
                        Twitter.</p>
                </div>

                <div class="card-body">
                    <form action="{{ route('users.transactions.storeTransactionMass') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="digital_platform" class="form-label">Digital Platform</label>
                                    <select class="form-select select2" id="digital_platform" name="digital_platform_id"
                                        required>
                                        <option value="" selected>Select Platform</option>
                                        @foreach ($digitalPlatforms as $platform)
                                            <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="interaction_type" class="form-label">Interaction Type</label>
                                    <select class="form-select select2" id="interaction_type" name="interaction_type_id"
                                        required>
                                        <option value="" selected>Select Interaction Type</option>
                                        @foreach ($interactionTypes as $interaction)
                                            <option value="{{ $interaction->id }}">{{ $interaction->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row d-none" id="service-container">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="service" class="form-label">Service</label>
                                    <select class="form-select select2" id="service" name="service_id" required>
                                        <option value="" selected>Select Service</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="serviceDetails" class="d-none border border-primary rounded p-3 mb-3">
                            <p id="serviceName" class="fw-medium mb-0"></p>
                            <p id="servicePrice" class="fw-bold"></p>
                            <p id="minQty" class="fw-bold"></p>
                            <p id="maxQty" class="fw-bold"></p>
                        </div>

                        <!-- Bulk Order Grouping -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title">Bulk Orders</h5>
                            </div>
                            <div class="card-body" id="bulkEntries">
                                <!-- Group Row Template -->
                                <div class="d-flex align-items-end mb-3 entry-row">
                                    <div class="flex-grow-1 me-2">
                                        <label for="target_link_1" class="form-label">Link Target</label>
                                        <input type="text" class="form-control" id="target_link_1" name="target_link[]"
                                            placeholder="Enter target link" required>
                                    </div>

                                    <div class="me-2">
                                        <label for="quantity_1" class="form-label">Quantity</label>
                                        <input type="number" class="form-control quantity-input" id="quantity_1"
                                            name="quantity[]" min="0" placeholder="Enter quantity" required>
                                    </div>

                                    <div class="me-2">
                                        <label for="totalPrice_1" class="form-label">Price</label>
                                        <input type="text" class="form-control total-price-input" id="totalPrice_1"
                                            name="total_price[]" placeholder="Rp" readonly>
                                    </div>

                                    <div>
                                        <button type="button" class="btn btn-danger btn-sm delete-entry">Delete</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Add More Button -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-success btn-sm" id="addMoreBtn">Add More</button>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(document).ready(function() {
                let entryIndex = 1;
                const maxEntries = 20;
                let servicePrice = 0; // Tambahkan variabel untuk menyimpan harga layanan

                // Add more rows for bulk order
                $('#addMoreBtn').on('click', function() {
                    if (entryIndex < maxEntries) {
                        entryIndex++;
                        const newEntryRow = `
                <div class="d-flex align-items-end mb-3 entry-row">
                    <div class="flex-grow-1 me-2">
                        <label for="target_link_${entryIndex}" class="form-label">Link Target</label>
                        <input type="text" class="form-control" id="target_link_${entryIndex}" name="target_link[]" placeholder="Enter target link" required>
                    </div>
                    <div class="me-2">
                        <label for="quantity_${entryIndex}" class="form-label">Quantity</label>
                        <input type="number" class="form-control quantity-input" id="quantity_${entryIndex}" name="quantity[]" min="0" placeholder="Enter quantity" required>
                    </div>
                    <div class="me-2">
                        <label for="totalPrice_${entryIndex}" class="form-label">Price</label>
                        <input type="text" class="form-control total-price-input" id="totalPrice_${entryIndex}" name="total_price[]" placeholder="Rp" readonly>
                    </div>
                    <div>
                        <button type="button" class="btn btn-danger btn-sm delete-entry">Delete</button>
                    </div>
                </div>
            `;
                        $('#bulkEntries').append(newEntryRow);

                        // Attach delete event to new rows
                        $('.delete-entry').on('click', function() {
                            $(this).closest('.entry-row').remove();
                            entryIndex--;
                        });
                    } else {
                        alert('You can only add up to 20 entries.');
                    }
                });

                // Dynamic service loading
                $('#digital_platform, #interaction_type').on('change', function() {
                    const platformId = $('#digital_platform').val();
                    const interactionId = $('#interaction_type').val();
                    if (platformId && interactionId) {
                        $.ajax({
                            url: `/get-services/${platformId}/${interactionId}`,
                            type: 'GET',
                            success: function(data) {
                                $('#service').empty().append(
                                    '<option value="" selected>Select Service</option>');
                                data.forEach(service => {
                                    $('#service').append(
                                        `<option value="${service.id}" data-name="${service.type}" data-price="${service.price}" data-min="${service.min}" data-max="${service.max}">${service.type.toUpperCase()} - Rp ${service.price.toLocaleString()}/K</option>`
                                        );
                                });
                                $('#service-container').removeClass('d-none');
                            }
                        });
                    }
                });

                // Update service details on change
                $('#service').on('change', function() {
                    const selectedOption = $(this).find('option:selected');
                    const serviceName = selectedOption.data('name');
                    servicePrice = selectedOption.data('price'); // Simpan harga layanan
                    const minQty = selectedOption.data('min');
                    const maxQty = selectedOption.data('max');

                    $('#serviceName').text(`Service Name: ${serviceName.toUpperCase()}`);
                    $('#servicePrice').text(`Price: Rp ${servicePrice.toLocaleString()}/K`);
                    $('#minQty').text(`Min Qty: ${minQty}`);
                    $('#maxQty').text(`Max Qty: ${maxQty}`);

                    $('#serviceDetails').removeClass('d-none');
                });

                // Recalculate total price whenever quantity is changed
                $(document).on('input', '.quantity-input', function() {
                    const quantity = $(this).val();
                    const totalPrice = Math.ceil((quantity * servicePrice) /
                    1000); // Hitung total harga dan bulatkan ke atas
                    $(this).closest('.entry-row').find('.total-price-input').val(
                        `Rp ${totalPrice.toLocaleString()}`);
                });
            });
        </script>


        <div class="col-lg-5">
            <div class="card">
                <div class="card-header border-bottom border-dashed">
                    <h4 class="card-title">Informasi</h4>
                </div>
                <div class="card-body">
                    <p><strong>Langkah-langkah membuat pesanan baru:</strong></p>
                    <ul>
                        <li>Pilih salah satu Kategori.</li>
                        <li>Pilih salah satu Layanan yang ingin dipesan.</li>
                        <li>Masukkan Target pesanan sesuai ketentuan yang diberikan layanan tersebut.</li>
                        <li>Masukkan Jumlah Pesanan yang diinginkan.</li>
                        <li>Klik Submit untuk membuat pesanan baru.</li>
                    </ul>
                    <p><strong>Ketentuan membuat pesanan baru:</strong></p>
                    <ul>
                        <li>Silahkan membuat pesanan sesuai langkah-langkah diatas.</li>
                        <li>Jika ingin membuat pesanan dengan Target yang sama dengan pesanan yang sudah pernah dipesan
                            sebelumnya, mohon menunggu sampai pesanan sebelumnya selesai diproses.</li>
                        <li>Jika terjadi kesalahan / mendapatkan pesan gagal yang kurang jelas, silahkan hubungi Admin untuk
                            informasi lebih lanjut.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
