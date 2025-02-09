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

        .forPraImg::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        
        .forPraImg::-webkit-scrollbar-thumb {
            background: #888; 
        }

        .forPraImg::-webkit-scrollbar-thumb:hover {
            background: #555; 
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
            -ms-transform: translate(-50%, -50%);
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
                        <a href="{{ route('admin.' . $active . '.index') }}" class="text-muted">{{ $title ?? '' }}</a>
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
                        <!-- Organisasi -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Organisasi <span class="text-danger">*</span></label>
                            <select name="organisasi_id" class="form-control @error('organisasi_id') is-invalid @enderror">
                                <option value="">Pilih Organisasi</option>
                                @foreach($organisasis as $organisasi)
                                    <option value="{{ $organisasi->id }}"
                                        {{ old('organisasi_id', $data->organisasi_id) == $organisasi->id ? 'selected' : '' }}>
                                        {{ $organisasi->user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('organisasi_id')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Nama Kegiatan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kegiatan" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                placeholder="Enter Nama Kegiatan" value="{{ old('nama_kegiatan', $data->nama_kegiatan ?? '') }}" />
                            @error('nama_kegiatan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Deskripsi Kegiatan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                            <textarea name="deskripsi_kegiatan" class="form-control @error('deskripsi_kegiatan') is-invalid @enderror"
                                placeholder="Enter Deskripsi Kegiatan" rows="5">{{ old('deskripsi_kegiatan', $data->deskripsi_kegiatan ?? '') }}</textarea>
                            @error('deskripsi_kegiatan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Tanggal Pelaksanaan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pelaksanaan" class="form-control @error('tanggal_pelaksanaan') is-invalid @enderror"
                                value="{{ old('tanggal_pelaksanaan', $data->tanggal_pelaksanaan ?? '') }}" />
                            @error('tanggal_pelaksanaan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Tanggal Pengajuan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Tanggal Pengajuan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pengajuan" class="form-control @error('tanggal_pengajuan') is-invalid @enderror"
                                value="{{ old('tanggal_pengajuan', $data->tanggal_pengajuan ?? '') }}" />
                            @error('tanggal_pengajuan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Skala Kegiatan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Skala Kegiatan <span class="text-danger">*</span></label>
                            <select name="skala_kegiatan" class="form-control @error('skala_kegiatan') is-invalid @enderror">
                                <option value="lokal" {{ old('skala_kegiatan', $data->skala_kegiatan) == 'lokal' ? 'selected' : '' }}>Lokal</option>
                                <option value="nasional" {{ old('skala_kegiatan', $data->skala_kegiatan) == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                <option value="internasional" {{ old('skala_kegiatan', $data->skala_kegiatan) == 'internasional' ? 'selected' : '' }}>Internasional</option>
                            </select>
                            @error('skala_kegiatan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Kebutuhan Dana -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Kebutuhan Dana <span class="text-danger">*</span></label>
                            <input type="number" name="kebutuhan_dana" class="form-control @error('kebutuhan_dana') is-invalid @enderror"
                                value="{{ old('kebutuhan_dana', $data->kebutuhan_dana ?? '') }}" />
                            @error('kebutuhan_dana')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Nomor Rekening -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Nomor Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="nomor_rekening" class="form-control @error('nomor_rekening') is-invalid @enderror"
                                value="{{ old('nomor_rekening', $data->nomor_rekening ?? '') }}" />
                            @error('nomor_rekening')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Nama Rekening -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Nama Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="nama_rekening" class="form-control @error('nama_rekening') is-invalid @enderror"
                                value="{{ old('nama_rekening', $data->nama_rekening ?? '') }}" />
                            @error('nama_rekening')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Nama Bank -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Nama Bank <span class="text-danger">*</span></label>
                            <input type="text" name="nama_bank" class="form-control @error('nama_bank') is-invalid @enderror"
                                value="{{ old('nama_bank', $data->nama_bank ?? '') }}" />
                            @error('nama_bank')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Link Drive -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Link Drive <span class="text-danger">*</span></label>
                            <input type="url" name="link_drive" class="form-control @error('link_drive') is-invalid @enderror"
                                value="{{ old('link_drive', $data->link_drive ?? '') }}" />
                            @error('link_drive')
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
@endsection
