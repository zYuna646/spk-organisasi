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
                        <!-- Input untuk Title -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                placeholder="Enter Title" value="{{ old('title') }}" />
                            @error('title')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Input untuk Content dengan TinyMCE -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Content <span class="text-danger">*</span></label>
                            <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="5"
                                placeholder="Enter Content">{{ old('content') }}</textarea>
                            @error('content')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <!-- Input untuk Cover Image -->
                        <div class="mb-3">
                            <label class="control-label mb-1">Cover Image</label>
                            <input type="file" name="cover"
                                class="form-control @error('cover') is-invalid @enderror" />
                            @error('cover')
                                <small class="invalid-feedback">
                                    {{ $message }}
                                </small>
                            @enderror
                            <small class="text-muted">Format: jpg, jpeg, png, gif (max: 2MB)</small>
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

        }
        });
    </script>
@endpush
