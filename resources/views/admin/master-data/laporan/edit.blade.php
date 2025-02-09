@extends('admin.layouts.app')

@push('styles')
    <style>
        .btn-modal-close {
            width: 30px;
            height: 30px;
            font-size: 12px;
            color: #fff;
            background-color: rgba(255, 255, 255, .3);
            border: none;
            border-radius: 50%;
            outline: none;
            cursor: pointer;
        }

        .forPraImg {
            overflow-x: auto !important; 
            overflow-y: hidden; 
            width: 100%;
        }

        .forPraImg::-webkit-scrollbar {
            height: 6px;
        }
        
        .forPraImg::-webkit-scrollbar-thumb {
            background: #888; 
        }

        .my-content-img {
            position: relative;
        }

        .my-content-img:before {
            content:"";
            position:absolute;
            width:100%;
            height:100%;
            top:0;left:0;right:0;
            background-color:rgba(0,0,0,0);
            transition: .3s ease-in-out;
        }

        .my-content-img:hover::before {
            background-color:rgba(0,0,0,0.5);
        }

        .my-content-img .my-btn-img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity:0;
            transition: .3s ease-in-out;
        }

        .my-content-img:hover .my-btn-img {   
            opacity: 1;
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
                        <a href="{{ route('admin.' . $active .'.index') }}" class="text-muted">{{ $title ?? '' }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $subtitle ?? '' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert" id="success-alert">
            <div class="d-flex gap-2 align-items-center">
                <div>
                    <span class="d-inline-flex p-1 rounded-circle border border-2 border-white mb-0">
                        <i class="fs-5 ti ti-check"></i> 
                    </span>
                </div> 
                <div>
                    {{ $message ?? '' }}
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <form action="{{ route('admin.' . $active . '.update', $data->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put') <!-- Metode PUT untuk Update -->
            <div class="card-body">
                <h5 class="mb-3">{{ $subtitle }} Form</h5>
                <div class="row">
                    <div class="col-12">
                        <!-- Name Field -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter Name" value="{{ old('name', $data->name ?? '') }}" />
                            @error('name')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Email <span class="text-danger">*</span></label>
                            <input type="email" name="user_email" class="form-control @error('user_email') is-invalid @enderror"
                                placeholder="Enter Email" value="{{ old('user_email', $data->email ?? '') }}" />
                            @error('user_email')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter Password" />
                            @error('password')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Phone Number Field -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                                placeholder="Enter Phone Number" value="{{ old('no_hp', $data->no_hp) }}" />
                            @error('no_hp')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="card-body border-top">
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-device-floppy me-1 fs-4"></i>
                            Update
                        </div>
                    </button>
                    <button type="reset" class="btn btn-danger rounded-pill px-4 ms-2 text-white">
                        Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Other Images Section --}}
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#priceInput').on('input', function() {
                let inputValue = $(this).val().replace(/\D/g, '');
                inputValue = addCommas(inputValue);
                $(this).val(inputValue);
            });

            function addCommas(nStr) {
                nStr += '';
                var x = nStr.split('.');
                var x1 = x[0];
                var x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }
        });
    </script>
@endpush
