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
            <h4 class="fw-semibold mb-8">{{ $title ?? 'Detail Laporan Kegiatan' }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.laporan.index') }}" class="text-muted">Laporan Kegiatan</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $subtitle ?? 'Detail' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="shop-detail">
        <div class="card shadow-none border">
            <div class="card-body p-4">
                <a href="{{ route('admin.laporan.index') }}" class="btn btn-sm btn-dark mb-3"><i
                        class="ti ti-arrow-left"></i> Back to Laporan Kegiatan</a>
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
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                {{ $data->relevansi }}

                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="shop-content">
                            <h4 class="fw-semibold">{{ $data->nama_kegiatan ?? 'No Name Available' }}</h4>
                            <p class="mb-3">{{ $data->tujuan_kegiatan ?? 'No description available.' }}</p>

                            <div class="border-top border-bottom py-3">
                                <table>
                                    <tr>
                                        <td><strong>Organisasi</strong></td>
                                        <td>:</td>
                                        <td>{{ $data->organisasi->name ?? 'No organization' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Pelaksanaan</strong></td>
                                        <td>:</td>
                                        <td>{{ \Carbon\Carbon::parse($data->tanggal_pelaksanaan)->format('d M Y') ?? 'No date' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tempat Kegiatan</strong></td>
                                        <td>:</td>
                                        <td>{{ $data->tempat_kegiatan ?? 'Not provided' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tujuan Kegiatan</strong></td>
                                        <td>:</td>
                                        <td>{{ $data->tujuan_kegiatan ?? 'Not provided' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Laporan Kegiatan (PDF)</strong></td>
                                        <td>:</td>
                                        <td><a href="{{ Storage::url('public/uploads/laporan/laporan_kegiatan/' . $data->laporan_kegiatan) }}"
                                                target="_blank">Download Laporan</a></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="mt-3">
                                @if (Auth::user()->role->slug === 'organisasi')
                                
                                @else
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                        <i class="ti ti-trash"></i> Tolak Kegiatan
                                    </button>
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#acceptModal">
                                        <i class="ti ti-check"></i> Terima Kegiatan
                                    </button>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.' . $active . '.tolak', $data->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Tolak Kegiatan</h5>
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
                        <button type="submit" class="btn btn-danger">Tolak Kegiatan</button>
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
                        <h5 class="modal-title" id="acceptModalLabel">Terima Kegiatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Terima Kegiatan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Optionally, you can add any additional JS functionality for the page.
    </script>
@endpush
