@extends('admin.layouts.app')

@section('content')
    <div class="card bg-light-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <h4 class="fw-semibold mb-8">{{ $title ?? 'Create Organization' }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.organisasi.index') }}" class="text-muted">Organisasi</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $subtitle ?? 'Create' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('admin.organisasi.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <h5 class="mb-3">{{ $subtitle }} Form</h5>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="control-label mb-1">Nama Organisasi <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Organization Name"
                                value="{{ old('name') }}" />
                            @error('name')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="control-label mb-1">Ketua Umum <span class="text-danger">*</span></label>
                            <input type="text" name="ketua_umum" class="form-control @error('ketua_umum') is-invalid @enderror" placeholder="Organization Name"
                                value="{{ old('ketua_umum') }}" />
                            @error('ketua_umum')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="control-label mb-1">Email <span class="text-danger">*</span></label>
                            <input type="email" name="user_email" class="form-control @error('user_email') is-invalid @enderror" placeholder="Email"
                                value="{{ old('user_email') }}" />
                            @error('user_email')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="control-label mb-1">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" />
                            @error('password')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="control-label mb-1">Phone Number</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" />
                        </div>
                        <div class="mb-3">
                            <label class="control-label mb-1">Tahun Berdiri <span class="text-danger">*</span></label>
                            <input type="number" name="tahun_berdiri" class="form-control @error('tahun_berdiri') is-invalid @enderror"
                                value="{{ old('tahun_berdiri') }}" />
                            @error('tahun_berdiri')
                                <small class="invalid-feedback">{{ $message }}</small>
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
                            Save
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
