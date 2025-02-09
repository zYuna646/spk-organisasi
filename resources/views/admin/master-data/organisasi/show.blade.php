@extends('admin.layouts.app')

@push('styles')
    <style>
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
                        <a href="{{ route('admin.organisasi.index') }}" class="text-muted">Organisasi</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $subtitle ?? '' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="shop-detail">
        <div class="card shadow-none border">
            <div class="card-body p-4">
                <a href="{{ route('admin.' . $active . '.index') }}" class="btn btn-sm btn-dark mb-3"><i
                        class="ti ti-arrow-left"></i> Back to {{ $title ?? '' }}</a>

                <div class="row g-4">
                    <div class="col-lg-5">
                        <!-- Optional: You can add an image for the organization if applicable -->
                        <div class="item rounded overflow-hidden">
                            {{-- <img src="{{ asset('uploads/organisasi/' . $data->logo) }}" alt="Organisasi Logo" class="img-fluid"> --}}
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="shop-content">
                            <!-- Organization Name -->
                            <h4 class="fw-semibold">{{ $data->user->name }}</h4>
                            {{-- <p class="mb-3">{{ $data->description ?? 'No description available' }}</p> --}}

                            <!-- Contact Info (User) -->
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="fs-4">Contact Person</span>
                                {{-- <span class="badge text-bg-info fs-4 fw-semibold rounded-3">{{ $data->user->name ?? 'N/A' }}</span> --}}
                            </div>

                            <h5 class="fw-semibold">Email: {{ $data->user->email ?? 'Not Provided' }}</h5>
                            <h5 class="fw-semibold">Phone: {{ $data->user->no_hp ?? 'Not Provided' }}</h5>

                            <!-- Organization Details -->
                            <div class="border-top border-bottom py-3">
                                <table>
                                    <tr>
                                        <td><strong>Year of Establishment</strong></td>
                                        <td>:</td>
                                        <td>{{ $data->tahun_berdiri }}</td>
                                    </tr>
                                 
                                </table>
                            </div>

                            <!-- Actions: Edit and Delete -->
                            <div class="mt-3">
                                <a href="{{ route('admin.' . $active . '.edit', $data->id) }}" class="btn btn-warning">
                                    <i class="ti ti-pencil"></i> Edit Organization
                                </a>
                                <form action="{{ route('admin.' . $active . '.destroy', $data->id) }}" method="post"
                                    class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="ti ti-trash"></i> Delete Organization
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
