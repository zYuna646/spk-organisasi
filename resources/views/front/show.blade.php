@extends('front.layouts.app')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
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

        table tr td {
            padding: 5px;
        }
    </style>
@endpush

@section('content')
    <section class="product-detail">
        <div class="container">
            <div class="shop-detail">
                <div class="card shadow-none border">
                    <div class="card-body p-4">
                        <a href="{{ route('cart.history') }}" class="btn btn-sm btn-dark mb-3"><i
                                class="ti ti-arrow-left"></i>
                            Back to History</a>

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
                                                    {{ $result }}

                                                </td>
                                                <td>{{ App\Models\Catalog::find($key)->price * $result }}</td>
                                                <td>
                                                    <img style="width: 100px; height:85px"
                                                        src="{{ asset('uploads/catalog/image/' . App\Models\Catalog::find($key)->image) }}"
                                                        alt="{{ App\Models\Catalog::find($key)->name }}"
                                                        class="img-fluid rounded" width="100" height="100">
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
                        </div>
                    </div>
                </div>
            </div>
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
        < script src = "https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity = "sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin = "anonymous"
        referrerpolicy = "no-referrer" >
            <
            /> <
        script >
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
                        '<span class="position-absolute top-50 start-0 ms-2 translate-middle-y btn-nav-dark rounded-circle"><i class="ti ti-chevron-left"></i></span>',
                        '<span class="position-absolute top-50 end-0 me-2 translate-middle-y btn-nav-dark rounded-circle"><i class="ti ti-chevron-right"></i></span>'
                    ],
                });
            })
    </script>
    </script>
@endpush
