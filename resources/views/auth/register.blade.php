@extends('auth.layouts.app')

@push('styles')
    <style>
        .shbtn-group {
            position: relative;
            overflow: hidden;
        }

        .shbtn {
            cursor: pointer;
            position: absolute;
            right: 0;
            top: 0;
            transform: translate(-50%, 50%);
            background: transparent;
            padding: 0 5px;
            z-index: 99;
            border: none;
        }

        .shbtn i {
            font-size: 18px;
            color: #333;
        }

        /* Adjust card width */
        .col-md-10,
        .col-lg-8,
        .col-xxl-6 {
            max-width: 100%;
            /* Card lebih lebar */
        }

        .card {
            max-width: 1100px;
            /* Lebarkan card menjadi 1100px */
            margin: 0 auto;
        }

        /* Form container with wider width */
        .form-container {
            max-width: 1100px;
            /* Lebarkan form container */
            margin: 0 auto;
            padding: 30px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group input {
            padding: 12px;
            /* Tambah padding agar lebih nyaman */
            font-size: 0.9rem;
            /* Ukuran font input lebih kecil */
        }

        .form-group label {
            font-size: 0.85rem;
            /* Ukuran font label lebih kecil agar lebih kompak */
        }

        .text-center {
            margin-top: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-row .form-group {
            margin-bottom: 0;
            /* Menghilangkan margin bawah agar lebih kompak */
        }

        /* Menambahkan jarak pada logo */
        .logo-img {
            margin-top: 30px;
            /* Jarak logo ke atas */
        }

        /* Menambahkan jarak pada tombol login */
        .mt-4 {
            margin-top: 30px;
            /* Memberikan jarak pada tombol login */
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
                width: 90%;
            }

            .form-container {
                grid-template-columns: 1fr;
                /* Satu kolom pada layar kecil */
            }

            .form-row {
                grid-template-columns: 1fr;
                /* Satu kolom untuk layar kecil */
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed"
        data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-10 col-lg-8 col-xxl-6">
                        <div class="card mb-0">
                            <div class="card-body form-container">
                                <!-- Logo -->
                                <a href="{{ url('/') }}" class="text-nowrap logo-img text-center d-block w-100">
                                    <img src="{{ asset('assets/front/img/logo.jpg') }}" width="180" alt="">
                                </a>

                                <div class="position-relative text-center my-4">
                                    <p class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative">
                                        Register
                                    </p>
                                    <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                                </div>

                                <!-- Form -->
                                <form action="{{ route('register.submit') }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-row">
                                        <!-- Nama Organisasi -->
                                        <div class="form-group">
                                            <label for="name" class="form-label">Nama Organisasi</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nama Organisasi">
                                            @error('name')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Nama Ketua Umum -->
                                        <div class="form-group">
                                            <label for="ketua_umum" class="form-label">Nama Ketua Umum</label>
                                            <input type="text" name="ketua_umum" class="form-control @error('ketua_umum') is-invalid @enderror" id="ketua_umum" placeholder="Nama Ketua Umum">
                                            @error('ketua_umum')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <!-- Email -->
                                        <div class="form-group">
                                            <label for="user_email" class="form-label">Email</label>
                                            <input type="email" name="user_email" class="form-control @error('user_email') is-invalid @enderror" id="user_email" placeholder="example@email.com">
                                            @error('user_email')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Tahun Berdiri -->
                                        <div class="form-group">
                                            <label for="tahun_berdiri" class="form-label">Tahun Berdiri</label>
                                            <input type="number" name="tahun_berdiri" class="form-control @error('tahun_berdiri') is-invalid @enderror" id="tahun_berdiri" placeholder="Tahun Berdiri">
                                            @error('tahun_berdiri')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <!-- Password -->
                                        <div class="form-group">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="shbtn-group">
                                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                                                <span class="shbtn">
                                                    <i class="ti ti-eye-off"></i>
                                                </span>
                                            </div>
                                            @error('password')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Nomor HP -->
                                        <div class="form-group">
                                            <label for="no_hp" class="form-label">Nomor HP (Optional)</label>
                                            <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" placeholder="Nomor HP">
                                            @error('no_hp')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-dark w-100 py-3 rounded-2 mt-4">Register</button>
                                </form>

                                <!-- Button to go to login page -->
                                <div class="mt-4 text-center">
                                    <p>Already have an account? <a href="{{ route('login') }}" class="btn btn-link">Login</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // show hide password jquery
        $(document).ready(function() {
            $("#show_hide_password span").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("ti-eye-off");
                    $('#show_hide_password i').removeClass("ti-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("ti-eye-off");
                    $('#show_hide_password i').addClass("ti-eye");
                }
            });
        });
    </script>
@endpush
