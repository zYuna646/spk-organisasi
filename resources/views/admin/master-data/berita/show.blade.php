@extends('admin.layouts.app')

@push('styles')
    <style>
        /* #sync1 .btn-nav-dark {
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
        } */

        table tr td {
            padding: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">{{ $title ?? '' }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.' . $active.'.index') }}" class="text-muted">{{ $title ?? '' }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $subtitle ?? '' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="shop-detail">
        <div class="card shadow-none border">
            <div class="card-body p-4">
                <a href="{{ route('admin.' . $active.'.index') }}" class="btn btn-sm btn-dark mb-3"><i class="ti ti-arrow-left"></i> Back to {{ $title ?? '' }}</a>

                <div class="row g-4">
                    <div class="col-lg-5">
                        <div id="sync1" class="owl-carousel owl-theme">
                            <div class="item rounded overflow-hidden">
                                {{-- <img src="{{ asset('uploads/diaspora/profile/' . $data->profile_image) }}" alt="Profile Image" class="img-fluid"> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="shop-content">
                            <h4 class="fw-semibold">{{ $data->name ?? '' }}</h4>
                            {{-- <p class="mb-3">{{ $data->bio ?? 'No bio available.' }}</p> --}}
                            <h4 class="fw-semibold mb-3">{{ $data->email ?? 'No email provided.' }}</h4>

                            <div class="border-top border-bottom py-3">
                                <table>
                                    <tr>
                                        <td><strong>Phone Number</strong></td>
                                        <td>:</td>
                                        <td>{{ $data->no_hp ?? 'Not provided' }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td><strong>Address</strong></td>
                                        <td>:</td>
                                        <td>{{ $data->address ?? 'Not provided' }}</td>
                                    </tr> --}}
                                </table>
                            </div>

                            <div class="mt-3">
                                <a href="{{ route('admin.' . $active . '.edit', $data->id) }}" class="btn btn-warning">
                                    <i class="ti ti-pencil"></i> Edit Profile
                                </a>
                                <form action="{{ route('admin.' . $active . '.destroy', $data->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this profile?')">
                                        <i class="ti ti-trash"></i> Delete Profile
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // profile carousel
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
    </script> --}}
@endpush
