@extends('admin.layouts.app')

@push('styles')
    <style>
        /* Tambahkan CSS tambahan jika diperlukan */
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
                        <!-- Organisasi -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Organisasi <span class="text-danger">*</span></label>
                            <select name="organisasi_id" class="form-control @error('organisasi_id') is-invalid @enderror">
                                <option value="">Pilih Organisasi</option>
                                @foreach ($organisasis as $organisasi)
                                    <option value="{{ $organisasi->id }}" {{ old('organisasi_id', $data->organisasi_id) == $organisasi->id ? 'selected' : '' }}>
                                        {{ $organisasi->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('organisasi_id')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Tanggal Pengajuan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Tanggal Pengajuan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pengajuan" class="form-control @error('tanggal_pengajuan') is-invalid @enderror"
                                value="{{ old('tanggal_pengajuan', $data->tanggal_pengajuan->format('Y-m-d')) }}" />
                            @error('tanggal_pengajuan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Nama Kegiatan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kegiatan" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                placeholder="Masukkan Nama Kegiatan" value="{{ old('nama_kegiatan', $data->nama_kegiatan) }}" />
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
                                placeholder="Deskripsi kegiatan">{{ old('deskripsi_kegiatan', $data->deskripsi_kegiatan) }}</textarea>
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
                                value="{{ old('tanggal_pelaksanaan', $data->tanggal_pelaksanaan->format('Y-m-d')) }}" />
                            @error('tanggal_pelaksanaan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Skala Kegiatan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Skala Kegiatan <span class="text-danger">*</span></label>
                            <select name="skala_kegiatan" class="form-control @error('skala_kegiatan') is-invalid @enderror">
                                <option value="daerah" {{ old('skala_kegiatan', $data->skala_kegiatan) == 'daerah' ? 'selected' : '' }}>Daerah</option>
                                <option value="provinsi" {{ old('skala_kegiatan', $data->skala_kegiatan) == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                                <option value="nasional" {{ old('skala_kegiatan', $data->skala_kegiatan) == 'nasional' ? 'selected' : '' }}>Nasional</option>
                            </select>
                            @error('skala_kegiatan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Surat Undangan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Surat Undangan (PDF) <span class="text-danger">*</span></label>
                            <input type="file" name="surat_undangan" class="form-control @error('surat_undangan') is-invalid @enderror" />
                            @error('surat_undangan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                            @if ($data->surat_undangan)
                                <div class="mt-2">
                                    <a href="{{ Storage::url('public/uploads/kegiatan/surat-undangan/' . $data->surat_undangan) }}" target="_blank">Lihat Surat Undangan</a>
                                </div>
                            @endif
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

@push('scripts')
    <script>
        $(document).ready(function() {
            // Additional JS logic if needed
        });
    </script>
@endpush
