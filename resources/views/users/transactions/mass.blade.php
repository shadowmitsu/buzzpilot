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
                        Twitter.
                    </p>

                    <!-- Alert for success or error -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
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
                        </div>

                        <div id="bulkEntries">
                            <div class="row entry-row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="target_link_1" class="form-label">Link Target</label>
                                        <input type="text" class="form-control" id="target_link_1" name="target_link[]"
                                            placeholder="Enter target link" required>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="mb-3">
                                        <label for="quantity_1" class="form-label">Quantity</label>
                                        <input type="number" class="form-control quantity-input" id="quantity_1"
                                            name="quantity[]" min="0" placeholder="Enter quantity" required>
                                    </div>
                                </div>

                                <div class="col-lg-4 comment-section d-none">
                                    <div class="mb-3">
                                        <label for="comments_1" class="form-label">Comments</label>
                                        <textarea class="form-control" id="comments_1" name="comments[]" rows="1"
                                            placeholder="Enter your comments (optional)"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="mb-3">
                                        <label for="totalPrice_1" class="form-label">Price</label>
                                        <input type="text" class="form-control total-price-input" id="totalPrice_1"
                                            name="total_price[]" placeholder="Rp" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-success" id="addMoreBtn">Add More</button>
                            </div>
                        </div>

                        <div class="row">
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

                // Add more entry rows
                $('#addMoreBtn').on('click', function() {
                    entryIndex++;
                    const newEntryRow = `
                        <div class="row entry-row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="target_link_${entryIndex}" class="form-label">Link Target</label>
                                    <input type="text" class="form-control" id="target_link_${entryIndex}" name="target_link[]" placeholder="Enter target link" required>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <label for="quantity_${entryIndex}" class="form-label">Quantity</label>
                                    <input type="number" class="form-control quantity-input" id="quantity_${entryIndex}" name="quantity[]" min="0" placeholder="Enter quantity" required>
                                </div>
                            </div>

                            <div class="col-lg-4 comment-section d-none">
                                <div class="mb-3">
                                    <label for="comments_${entryIndex}" class="form-label">Comments</label>
                                    <textarea class="form-control comments" id="comments_${entryIndex}" name="comments[]" rows="1" placeholder="Enter your comments (optional)"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <label for="totalPrice_${entryIndex}" class="form-label">Price</label>
                                    <input type="text" class="form-control total-price-input" id="totalPrice_${entryIndex}" name="total_price[]" placeholder="Rp" readonly>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#bulkEntries').append(newEntryRow);
                });

                // Interaction Type Change Listener
                $('#interaction_type').on('change', function() {
                    const selectedText = $(this).find('option:selected').text().toLowerCase();
                    const commentSection = $('.comment-section');
                    const quantityInput = $('.quantity-input');

                    if (selectedText.includes('comment')) {
                        commentSection.removeClass('d-none');
                        quantityInput.prop('readonly', true);

                        $('.comments').on('input', function() {
                            const commentValue = $(this).val();
                            const lineCount = commentValue.split(/\n/).length;
                            $(this).closest('.entry-row').find('.quantity-input').val(lineCount);
                            $(this).closest('.entry-row').find('.quantity-input').trigger('input');
                        });
                    } else {
                        commentSection.addClass('d-none');
                        quantityInput.prop('readonly', false);
                    }
                });

                // Fetch services based on platform and interaction type
                $('#digital_platform, #interaction_type').on('change', function() {
                    var platformId = $('#digital_platform').val();
                    var interactionId = $('#interaction_type').val();

                    if (platformId && interactionId) {
                        $.ajax({
                            url: `/get-services/${platformId}/${interactionId}`,
                            type: 'GET',
                            success: function(data) {
                                $('#service').empty().append(
                                    '<option value="" selected>Select Service</option>');
                                data.forEach(service => {
                                    let formattedPrice = new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(service.price);

                                    $('#service').append(`
                            <option value="${service.id}" 
                                data-name="${service.type}" 
                                data-price="${service.price}" 
                                data-min="${service.min}" 
                                data-max="${service.max}">
                                ${service.type.toUpperCase()} - ${formattedPrice}/K
                            </option>
                        `);
                                });
                                $('#service-container').removeClass('d-none');
                            }
                        });
                    }
                });

                // Service selection change listener
                $('#service').on('change', function() {
                    var selectedOption = $(this).find('option:selected');
                    var serviceName = selectedOption.data('name');
                    var servicePrice = selectedOption.data('price');
                    var minQty = selectedOption.data('min');
                    var maxQty = selectedOption.data('max');

                    $('#serviceName').text(`Service Name: ${serviceName.toUpperCase()}`);
                    $('#servicePrice').text(`Price: Rp ${servicePrice.toLocaleString()}/K`);

                    $('#quantity').attr('min', minQty);
                    $('#quantity').attr('max', maxQty);
                    $('#serviceDetails').removeClass('d-none');
                });

                // Quantity input event to calculate the total price
                $(document).on('input', '.quantity-input', function() {
                    var qty = $(this).val();
                    var pricePerThousand = $('#service').find('option:selected').data('price');
                    var totalPrice = (qty / 1000) * pricePerThousand;
                    var roundedPrice = Math.round(totalPrice);
                    $(this).closest('.entry-row').find('.total-price-input').val(
                        `Rp ${roundedPrice.toLocaleString()}`);
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
