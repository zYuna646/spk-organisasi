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
                        <a href="{{ route('admin.' . $active . '.index') }}" class="text-muted">{{ $title ?? '' }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $subtitle ?? '' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="shop-detail">
        <div class="card shadow-none border">
            <div class="card-body p-4">
                <a href="{{ route('admin.' . $active . '.index') }}" class="btn btn-sm btn-dark mb-3">
                    <i class="ti ti-arrow-left"></i> Back to {{ $title ?? '' }}
                </a>

                <div class="row g-4">
                    <div class="col-lg-7">
                        @if ($data->status_pengajuan == 'tolak')
                            <div class="alert alert-danger alert-dismissible bg-error text-white border-0" role="alert"
                                id="reject-alert">
                                <div class="d-flex gap-2 align-items-center">
                                    <div>
                                        <span class="d-inline-flex p-1 rounded-circle border border-2 border-white mb-0">
                                            <i class="fs-5 ti ti-x"></i> {{-- Icon for rejection --}}
                                        </span>
                                    </div>
                                    <div>
                                        {{ $data->pesan_pengajuan ?? 'No rejection message provided.' }}
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Display acceptance message if status is "terima" --}}
                        @if ($data->status_pengajuan == 'terima')
                            <div class="alert alert-success alert-dismissible bg-success text-white border-0" role="alert"
                                id="accept-alert">
                                <div class="d-flex gap-2 align-items-center">
                                    <div>
                                        <span class="d-inline-flex p-1 rounded-circle border border-2 border-white mb-0">
                                            <i class="fs-5 ti ti-check"></i> {{-- Icon for acceptance --}}
                                        </span>
                                    </div>
                                    <div>
                                        {{$data->relevansi}}
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="shop-content">
                            <h4 class="fw-semibold">{{ $data->nama_kegiatan ?? 'No Title' }}</h4>

                            <div class="border-top border-bottom py-3">
                                <table>
                                    <tr>
                                        <td><strong>Organisasi</strong></td>
                                        <td>:</td>
                                        <td>{{ $data->organisasi->user->name ?? 'Not Provided' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Deskripsi Kegiatan</strong></td>
                                        <td>:</td>
                                        <td>{{ $data->deskripsi_kegiatan ?? 'Not Provided' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Pelaksanaan</strong></td>
                                        <td>:</td>
                                        <td>{{ $data->tanggal_pelaksanaan ? \Carbon\Carbon::parse($data->tanggal_pelaksanaan)->format('d M Y') : 'Not Provided' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Pengajuan</strong></td>
                                        <td>:</td>
                                        <td>{{ $data->tanggal_pengajuan ? \Carbon\Carbon::parse($data->tanggal_pengajuan)->format('d M Y') : 'Not Provided' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Skala Kegiatan</strong></td>
                                        <td>:</td>
                                        <td>{{ ucfirst($data->skala_kegiatan) ?? 'Not Provided' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kebutuhan Dana</strong></td>
                                        <td>:</td>
                                        <td>{{ $data->kebutuhan_dana ?? 'Not Provided' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nomor Rekening</strong></td>
                                        <td>:</td>
                                        <td>{{ $data->nomor_rekening ?? 'Not Provided' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama Rekening</strong></td>
                                        <td>:</td>
                                        <td>{{ $data->nama_rekening ?? 'Not Provided' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama Bank</strong></td>
                                        <td>:</td>
                                        <td>{{ $data->nama_bank ?? 'Not Provided' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Link Drive</strong></td>
                                        <td>:</td>
                                        <td><a href="{{ $data->link_drive ?? '#' }}"
                                                target="_blank">{{ $data->link_drive ?? 'Not Provided' }}</a></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="mt-3">
                                @if (Auth::user()->role->slug === 'organisasi')
                                    <a href="{{ route('admin.' . $active . '.edit', $data->id) }}" class="btn btn-warning">
                                        <i class="ti ti-pencil"></i> Edit Proposal
                                    </a>
                                @else
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                        <i class="ti ti-trash"></i> Tolak Proposal
                                    </button>
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#acceptModal">
                                        <i class="ti ti-check"></i> Terima Proposal
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div id="sync1" class="owl-carousel owl-theme">
                            <div class="item rounded overflow-hidden">
                                <!-- Add any images related to the proposal if necessary -->
                                {{-- <img src="{{ asset('path_to_image') }}" alt="Proposal Image" class="img-fluid"> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.' . $active . '.tolak', $data->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Tolak Proposal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="pesan_penolakan" class="form-label">Pesan Penolakan</label>
                            <textarea name="pesan_penolakan" id="pesan_penolakan" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Tolak Proposal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Accept Modal -->
    <div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.' . $active . '.terima', $data->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="acceptModalLabel">Terima Proposal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="relevansi" class="form-label">Relevansi Proposal</label>
                            <select name="relevansi" id="relevansi" class="form-control" required>
                                <option value="Sangat Sesuai">Sangat Sesuai</option>
                                <option value="Sesuai">Sesuai</option>
                                <option value="Tidak Sesuai">Tidak Sesuai</option>
                                <option value="Sangat Tidak Sesuai">Sangat Tidak Sesuai</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Terima Proposal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // If you want to include the Owl Carousel functionality, you can uncomment this part.
        // $(function() {
        //     var sync1 = $("#sync1");
        //     sync1.owlCarousel({
        //         items: 1,
        //         slideSpeed: 2000,
        //         nav: true,
        //         autoplay: false,
        //         dots: false,
        //         loop: true,
        //         responsiveRefreshRate: 200,
        //         navText: [
        //             '<span class="position-absolute top-50 start-0 ms-2 translate-middle-y btn-nav-dark rounded-circle"><i class="ti ti-chevron-left"></i></span>',
        //             '<span class="position-absolute top-50 end-0 me-2 translate-middle-y btn-nav-dark rounded-circle"><i class="ti ti-chevron-right"></i></span>'
        //         ],
        //     });
        // });
    </script>
@endpush
