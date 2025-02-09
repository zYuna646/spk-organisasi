@extends('admin.layouts.app')

@push('styles')
    <!-- TinyMCE CSS (Opsional) -->
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
                                <option value="">Pilih Organisasi</option>
                                @foreach($organisasis as $organisasi)
                                    <option value="{{ $organisasi->id }}" {{ old('organisasi_id') == $organisasi->id ? 'selected' : '' }}>
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
                            <input type="text" name="nama_kegiatan" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                placeholder="Enter Nama Kegiatan" value="{{ old('nama_kegiatan') }}" />
                            @error('nama_kegiatan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Input untuk Deskripsi Kegiatan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                            <textarea name="deskripsi_kegiatan" class="form-control @error('deskripsi_kegiatan') is-invalid @enderror" rows="5"
                                placeholder="Enter Deskripsi Kegiatan">{{ old('deskripsi_kegiatan') }}</textarea>
                            @error('deskripsi_kegiatan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Input untuk Tanggal Pelaksanaan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pelaksanaan" class="form-control @error('tanggal_pelaksanaan') is-invalid @enderror"
                                value="{{ old('tanggal_pelaksanaan') }}" />
                            @error('tanggal_pelaksanaan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Input untuk Tanggal Pengajuan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Tanggal Pengajuan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pengajuan" class="form-control @error('tanggal_pengajuan') is-invalid @enderror"
                                value="{{ old('tanggal_pengajuan') }}" />
                            @error('tanggal_pengajuan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Input untuk Skala Kegiatan -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Skala Kegiatan <span class="text-danger">*</span></label>
                            <select name="skala_kegiatan" class="form-control @error('skala_kegiatan') is-invalid @enderror">
                                <option value="">Pilih Skala Kegiatan</option>
                                <option value="lokal" {{ old('skala_kegiatan') == 'lokal' ? 'selected' : '' }}>Lokal</option>
                                <option value="nasional" {{ old('skala_kegiatan') == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                <option value="internasional" {{ old('skala_kegiatan') == 'internasional' ? 'selected' : '' }}>Internasional</option>
                            </select>
                            @error('skala_kegiatan')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Input untuk Kebutuhan Dana -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Kebutuhan Dana <span class="text-danger">*</span></label>
                            <input type="number" name="kebutuhan_dana" class="form-control @error('kebutuhan_dana') is-invalid @enderror"
                                placeholder="Enter Kebutuhan Dana" value="{{ old('kebutuhan_dana') }}" />
                            @error('kebutuhan_dana')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Input untuk Nomor Rekening -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Nomor Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="nomor_rekening" class="form-control @error('nomor_rekening') is-invalid @enderror"
                                placeholder="Enter Nomor Rekening" value="{{ old('nomor_rekening') }}" />
                            @error('nomor_rekening')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Input untuk Nama Rekening -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Nama Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="nama_rekening" class="form-control @error('nama_rekening') is-invalid @enderror"
                                placeholder="Enter Nama Rekening" value="{{ old('nama_rekening') }}" />
                            @error('nama_rekening')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Input untuk Nama Bank -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Nama Bank <span class="text-danger">*</span></label>
                            <input type="text" name="nama_bank" class="form-control @error('nama_bank') is-invalid @enderror"
                                placeholder="Enter Nama Bank" value="{{ old('nama_bank') }}" />
                            @error('nama_bank')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Input untuk Link Drive -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Link Drive <span class="text-danger">*</span></label>
                            <input type="url" name="link_drive" class="form-control @error('link_drive') is-invalid @enderror"
                                placeholder="Enter Link Drive" value="{{ old('link_drive') }}" />
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
