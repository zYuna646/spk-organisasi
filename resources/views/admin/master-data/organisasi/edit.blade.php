@extends('admin.layouts.app')

@push('styles')
    <style>
        /* Your custom styles */
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
                        <a href="{{ route('admin.organisasi.index') }}" class="text-muted">Organisasi</a>

                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $subtitle ?? '' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Success Notification --}}
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert"
            id="success-alert">
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
            @method('put')
            <div class="card-body">
                <h5 class="mb-3">{{ $subtitle }} Form</h5>
                <div class="row">
                    <div class="col-12">
                        <!-- Organization Name -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Organization Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter organization name" value="{{ old('name', $data->user->name ?? '') }}" />
                            @error('name')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="control-label mb-1">Ketua Umum <span class="text-danger">*</span></label>
                            <input type="text" name="ketua_umum" class="form-control @error('ketua_umum') is-invalid @enderror" placeholder="Organization Name"
                                value="{{ old('ketua_umum', $data->ketua_umum) }}" />
                            @error('ketua_umum')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Organization Email -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Organization Email <span class="text-danger">*</span></label>
                            <input type="email" name="user_email"
                                class="form-control @error('user_email') is-invalid @enderror"
                                placeholder="Enter organization email"
                                value="{{ old('user_email', $data->user->email ?? '') }}" />
                            @error('user_email')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Year of Establishment -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Year of Establishment <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="tahun_berdiri"
                                class="form-control @error('tahun_berdiri') is-invalid @enderror"
                                placeholder="Enter year of establishment"
                                value="{{ old('tahun_berdiri', $data->tahun_berdiri ?? '') }}" />
                            @error('tahun_berdiri')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>


                        <!-- Contact Number (Optional) -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Phone Number</label>
                            <input type="text" name="no_hp" class="form-control"
                                value="{{ old('no_hp', $data->user->no_hp ?? '') }}" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit and Cancel Buttons -->
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
@endsection
