@extends('admin.layouts.app')

@push('styles')
    <!-- TinyMCE CSS (Optional) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.0/skins/ui/oxide/content.min.css" rel="stylesheet">
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

    <div class="card">
        <form action="{{ route('admin.' . $active . '.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <h5 class="mb-3">{{ $subtitle }} Form</h5>
                <div class="row">
                    <div class="col-12">
                        <!-- Input untuk Organisasi -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Organisasi <span class="text-danger">*</span></label>
                            <select name="organisasi_id" class="form-control @error('organisasi_id') is-invalid @enderror">
                                <option value="" disabled selected>Pilih Organisasi</option>
                                @foreach ($organisasis as $organisasi)
                                    <option value="{{ $organisasi->id }}"
                                        {{ old('organisasi_id') == $organisasi->id ? 'selected' : '' }}>
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

                        <!-- Input untuk Nama Kegiatan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kegiatan"
                                class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                placeholder="Enter Nama Kegiatan" value="{{ old('nama_kegiatan') }}" />
                            @error('nama_kegiatan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Input untuk Tanggal Pelaksanaan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pelaksanaan"
                                class="form-control @error('tanggal_pelaksanaan') is-invalid @enderror"
                                value="{{ old('tanggal_pelaksanaan') }}" />
                            @error('tanggal_pelaksanaan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Input untuk Tempat Kegiatan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Tempat Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_kegiatan"
                                class="form-control @error('tempat_kegiatan') is-invalid @enderror"
                                placeholder="Enter Tempat Kegiatan" value="{{ old('tempat_kegiatan') }}" />
                            @error('tempat_kegiatan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Input untuk Tujuan Kegiatan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Tujuan Kegiatan <span class="text-danger">*</span></label>
                            <textarea name="tujuan_kegiatan" class="form-control @error('tujuan_kegiatan') is-invalid @enderror"
                                placeholder="Enter Tujuan Kegiatan">{{ old('tujuan_kegiatan') }}</textarea>
                            @error('tujuan_kegiatan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Input untuk File Uploads -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Laporan Kegiatan (PDF) <span
                                    class="text-danger">*</span></label>
                            <input type="file" name="laporan_kegiatan"
                                class="form-control @error('laporan_kegiatan') is-invalid @enderror" />
                            @error('laporan_kegiatan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                            <small class="invalid-feedback">
                                lampirkan absensi peserta kegiatan, RAB kegiatan dan Dokumentasi Kegiatan
                            </small>
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

@push('scripts')
    <!-- TinyMCE Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.0/tinymce.min.js"></script>
    <script>
        // Inisialisasi TinyMCE
        tinymce.init({
            selector: '#content', // ID textarea
            height: 500, // Tinggi editor
            menubar: true, // Menampilkan menu bar
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic forecolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help | image | link',
            content_style: 'body { font-family: Arial, sans-serif; font-size: 16px; }',
        });
    </script>
@endpush
