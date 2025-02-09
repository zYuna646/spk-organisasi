@extends('front.layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBjEFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        .toast-success {
            background-color: #000 !important;
            /* Set your custom background color here */
        }

        .product-detail {
            margin: 40px 0;
        }

        .product-detail .card .card-body {
            padding: 60px !important;
        }

        .carousel-item img {
            width: 100%;
            height: 400px !important;
            object-fit: cover;
        }

        .header-slider .carousel .carousel-item .carousel-caption {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            text-align: left;
            color: white;
            padding: 20px;
        }

        .header-slider .carousel .carousel-item .carousel-caption h1 {
            font-size: 40px;
            font-weight: 700;
        }

        .header-slider .carousel .carousel-item .carousel-caption p {
            font-size: 14px;
            font-weight: 300;
            margin-bottom: 20px;
            text-wrap: wrap;
            width: 60%;
        }

        .btn-custom-transparent {
            background-color: transparent;
            color: var(--light-color);
            border: none;
            border-radius: 0;
            padding: 6px 20px;
            font-size: 14px;
            font-weight: 500;
            border: 2px solid var(--light-color);
            transition: all 0.3s;
        }

        .btn-custom-transparent:hover {
            background-color: var(--light-color);
            border: 2px solid var(--light-color);
            color: var(--dark-color);
        }

        @media (max-width: 991.98px) {
            .carousel-item img {
                height: 350px !important;
            }
        }

        @media (max-width: 767.98px) {
            .carousel-item img {
                width: 100%;
                height: 250px !important;
                object-fit: cover;
            }
        }

        #sync1 .btn-nav-dark {
            width: 20px;
            height: 20px;
            padding: 2px;
            background-color: rgba(0, 0, 0, .6);
            color: #fff;
            font-size: 12px;
        }

        #sync1 .owl-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            transform: translateY(-50%);
        }

        #sync1 .item {
            border-radius: 0 !important;
        }

        #sync1 .item img {
            height: fit-content;
            object-fit: cover;
        }

        table tr td {
            padding: 5px;
        }

        .category span {
            font-size: 14px !important;
        }

        .btn-copy {
            background-color: transparent;
            color: var(--dark-color);
            border: none;
            border-radius: 0;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            border: 2px solid var(--dark-color);
            transition: all 0.3s;
        }

        .btn-copy:hover {
            background-color: var(--dark-color);
            border: 2px solid var(--dark-color);
            color: var(--light-color);
        }

        .btn-shop {
            background-color: var(--dark-color);
            color: var(--light-color);
            border: none;
            border-radius: 0;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            border: 2px solid var(--dark-color);
            transition: all 0.3s;
        }

        .btn-shop:hover {
            background-color: var(--light-color);
            border: 2px solid var(--dark-color);
            color: var(--dark-color);
        }

        .related-product {
            margin-bottom: 50px;
        }

        .btn-see-more {
            text-decoration: none;
            color: var(--dark-color);
            font-size: 14px;
        }

        .btn-see-more:hover {
            text-decoration: underline;
        }
    </style>
@endpush

@section('content')
    <!-- Start Header Slider-->
    <header class="header-slider">
        <div class="container">
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($mainSliders as $key => $mainSlider)
                        <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                            <img src="{{ asset('uploads/main-slider/' . $mainSlider->image) }}" class="d-block w-100"
                                alt="Slider Image">
                            <div class="carousel-caption">
                                <h1>{{ $mainSlider->title ?? '' }}</h1>
                                <p class="text-wrap slider-subtitle">{{ $mainSlider->sub_title ?? '' }}</p>
                                <a href="{{ $mainSlider->link ?? '' }}" class="btn btn-custom-transparent">Shop Now</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </header>
    <!-- End Header Slider -->
    @if (count($product) > 0)
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Order</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('cart.cofirmation', $order->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <label class="control-label mb-1">Pilih Metode <span class="text-danger">*</span></label>
                                <select name="category_id"
                                    class="form-control form-select @error('category_id') is-invalid @enderror">
                                    <option value="" selected hidden>-- Select Metode --</option>
                                    <option value="cash">
                                        cash
                                    </option>
                                    <option value="bank">
                                        bank
                                    </option>
                                    <option value="cod" selected>
                                        cod
                                    </option>
                                </select>
                                <div id="bank">
                                    <h5 class="mb-3"><b>{{ $payment->bank }}</b>: {{ $payment->nomor_rekening }}</h5>
                                    <h6 class="mb-3"><b>{{ $payment->pemilik_rekening }}</b></h6>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="control-label mb-1">Bukti Pembayaran<span
                                                        class="text-danger">*</span></label>
                                                <input type="file" name="image"
                                                    class="form-control @error('image') is-invalid @enderror" />
                                                @error('image')
                                                    <small class="invalid-feedback">
                                                        {{ $message }}
                                                    </small>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="control-label mb-1">Alamat</label>
                                                <textarea name="alamat_bank" class="form-control" rows="4">{{ old('description') }}</textarea>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="cod">
                                    <div class="mb-3">
                                        <label class="control-label mb-1">Alamat</label>
                                        <textarea name="alamat_cod" class="form-control" rows="4">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-shop" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-shop">Order</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endif
    <!-- Modal -->


    <section class="product-detail">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-xl-3">
                            <div id="table_config_filter" class="position-relative">
                                <input type="search" id="search-box" class="form-control ps-5" aria-controls="table_config"
                                    placeholder="Search Product..." />
                                <i
                                    class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                            </div>
                        </div>
                        <div
                            class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                            <a class="btn btn-nav-link" href="{{ route('cart.history') }}">
                                <i class="fas fa-shopping-cart"></i>&nbsp;
                                History
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @if (count($product) > 0)
                <div class="card bg-transparent border-0 rounded-0">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_config" class="table align-middle text-nowrap">
                                    <thead class="header-item">
                                        <tr>
                                            <th>No</th>
                                            <th>Name Product</th>
                                            <th>Unit</th>
                                            <th>Category</th>
                                            <th>Amount</th>
                                            <th>Price</th>
                                            <th>Image</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product as $key => $result)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ App\Models\Catalog::find($key)->name }}</td>
                                                <td>{{ App\Models\Catalog::find($key)->fabric }}</td>
                                                <td>{{ App\Models\Catalog::find($key)->category->name }}</td>
                                                <td>
                                                    <form
                                                        action="{{ route('cart.add', App\Models\Catalog::find($key)->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('put')
                                                        <button type="submit" class="btn btn-sm btn-black"
                                                            onclick="return confirm('Are you sure?')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor"
                                                                class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    {{ $result }}
                                                    <form
                                                        action="{{ route('cart.minus', App\Models\Catalog::find($key)->id) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('put')
                                                        <button type="submit" class="btn btn-sm btn-black"
                                                            onclick="return confirm('Are you sure?')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor"
                                                                class="bi bi-dash-square-fill" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm2.5 7.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>{{ App\Models\Catalog::find($key)->price * $result }}</td>
                                                <td>
                                                    <img style="width: 100px; height:100px"
                                                        src="{{ asset('uploads/catalog/image/' . App\Models\Catalog::find($key)->image) }}"
                                                        alt="{{ App\Models\Catalog::find($key)->name }}"
                                                        class="img-fluid rounded" width="50" height="50">
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mb-3">
                                <button type="button" class="btn btn-shop" data-bs-target="#staticBackdrop" disabled>
                                    Total : Rp. {{ $total }}
                                </button>
                            </div>
                            <div class="mb-3">
                                <button type="button" class="btn btn-shop" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
                                    <i class="fa fa-shop"></i> Order Now
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // product detail
        $(function() {
            var sync1 = $("#sync1");

            sync1.owlCarousel({
                items: 1,
                slideSpeed: 2000,
                nav: true,
                autoplay: false,
                dots: false,
                loop: true,
                responsiveRefreshRate: 200,
                navText: [
                    '<span class="position-absolute top-50 start-0 ms-2 translate-middle-y btn-nav-dark rounded-circle"><i class="fa fa-chevron-left"></i></span>',
                    '<span class="position-absolute top-50 end-0 me-2 translate-middle-y btn-nav-dark rounded-circle"><i class="fa fa-chevron-right"></i></span>'
                ],
            });

            // Initialize Clipboard.js
            new ClipboardJS('.copy-link-button', {
                text: function(trigger) {
                    return $(trigger).attr('data-link');
                }
            });

            // Add a success event listener to show a Toastr toast notification
            $('.copy-link-button').on('click', function(e) {
                showCopySuccessNotification();
            });

            function showCopySuccessNotification() {
                // Show a Toastr toast notification
                toastr.success('Link Copied!', null, {
                    timeOut: 1500,
                    positionClass: 'toast-bottom-left',
                    progressBar: true,
                });
            }
        })

        $(document).ready(function() {
            // Initially hide the bank and cod sections
            $('#bank').hide();
            $('.cod').hide();

            // Listen for changes in the select element
            $('select[name="category_id"]').change(function() {
                // Get the selected value
                var selectedValue = $(this).val();

                $('#bank').hide();
                $('#cod').hide();

                // Show the selected section
                if (selectedValue === 'bank') {
                    $('#bank').show();
                } else if (selectedValue === 'cod') {
                    $('#cod').show();
                }
            });
        });
    </script>
@endpush
