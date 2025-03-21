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
                    <form action="{{ route('users.transactions.storeTransaction') }}" method="POST">
                        @csrf
                        <!-- Kategori Layanan -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Kategori</label>
                                    <select class="form-select select2" id="category" name="category_id" required>
                                        <option value="" selected>Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Layanan (Dynamic) -->
                        <div class="row d-none" id="service-container">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="service" class="form-label">Layanan</label>
                                    <select class="form-select select2" id="service" name="service_id" required>
                                        <option value="" selected>Pilih Layanan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi Card -->
                        <div id="serviceDetails" class="d-none border border-primary rounded p-3 mb-3">
                            <p id="serviceName" class="fw-medium mb-0"></p>
                            <p id="servicePrice" class="fw-bold"></p>
                            <p class="border-top small fw-bold mb-1 pt-1">Deskripsi:</p>
                            <p id="serviceDescription" class="mb-3"></p>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="target_link" class="form-label">Link Target</label>
                                    <input type="text" class="form-control" id="target_link" name="target_link"
                                        placeholder="Link Target" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 d-none" id="customCommentSection">
                            <label for="customComment" class="form-label">Custom Comment</label>
                            <textarea id="customComment" class="form-control" name="custom_comments" rows="3"
                                placeholder="Masukkan komentar kustom Anda di sini"></textarea>
                        </div>

                        <!-- Jumlah Min/Max -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Jumlah <span id="min-max-info">(Min: 0 Max:
                                            0)</span></label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" min="0"
                                        max="0" placeholder="Masukkan jumlah" required>
                                </div>
                            </div>
                        </div>

                        <!-- Biaya -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Biaya</label>
                                    <input type="text" class="form-control" id="totalPrice" name="total_price"
                                        placeholder="Rp" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Submit Order</button>
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
                $('.select2').select2();

                function escapeHTML(str) {
                    var div = document.createElement('div');
                    div.appendChild(document.createTextNode(str));
                    return div.innerHTML;
                }
                $('#category').on('change', function() {
                    var categoryId = $(this).val();

                    if (categoryId) {
                        $.ajax({
                            url: `/get-services/${categoryId}`,
                            type: 'GET',
                            success: function(data) {
                                $('#service').empty().append(
                                    '<option value="" selected>Pilih Layanan</option>');
                                data.forEach(service => {
                                    $('#service').append(
                                        `<option 
                                            value="${service.id}" 
                                            data-name="${service.name}" 
                                            data-price="${service.price}" 
                                            data-min="${service.min}" 
                                            data-max="${service.max}" 
                                            data-description="${escapeHTML(service.note)}" 
                                            data-type="${service.type}" 
                                            data-rating="0" 
                                            data-time="11 jam 20 menit 4 detik"> 
                                            ${service.name}
                                            </option>
                                        `
                                    );
                                });
                                $('#service-container').removeClass('d-none');
                            }
                        });
                    }
                });

                $('#service').on('change', function() {
                    var selectedOption = $(this).find('option:selected');
                    var serviceName = selectedOption.data('name');
                    var servicePrice = selectedOption.data('price');
                    var minQty = selectedOption.data('min');
                    var maxQty = selectedOption.data('max');
                    var serviceDescription = selectedOption.data('description');
                    var serviceType = selectedOption.data('type');
                    var serviceTime = selectedOption.data('time');
                    var serviceRating = selectedOption.data('rating');

                    $('#serviceName').text(`Nama Layanan: ${serviceName}`);
                    $('#servicePrice').text(`Harga: Rp ${servicePrice.toLocaleString()}/K`);
                    $('#serviceDescription').html(serviceDescription);
                    $('#serviceTime').text(serviceTime);
                    $('#serviceRating').html('<i class="fa fa-fw fa-star text-secondary"></i>'.repeat(5));
                    $('#serviceReviews').text(`(0 rating dari 0 penilaian)`);

                    $('#quantity').attr('min', minQty);
                    $('#quantity').attr('max', maxQty);
                    $('#min-max-info').text(`(Min: ${minQty} Max: ${maxQty})`);

                    if (serviceType === 'Custom Comments') {
                        $('#quantity').prop('readonly', true);
                        $('#quantity').val('0');
                        $('#totalPrice').val('Rp 0'); 
                        $('#customCommentSection').removeClass('d-none');
                    } else {
                        $('#quantity').prop('disabled', false);
                        $('#customCommentSection').addClass('d-none');
                    }

                    $('#serviceDetails').removeClass('d-none');
                });

                $('#quantity').on('input', function() {
                    var qty = $(this).val();
                    var pricePerThousand = $('#service').find('option:selected').data('price');
                    var totalPrice = (qty / 1000) * pricePerThousand;
                    var roundedPrice = Math.round(totalPrice);
                    $('#totalPrice').val(`Rp ${roundedPrice.toLocaleString()}`);
                });


                $('#customComment').on('input', function() {
                    var customComments = $(this).val().split(/\r\n|\n/);
                    var commentCount = customComments.length;
                    $('#quantity').val(commentCount);
                    $('#quantity').trigger('input');
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
