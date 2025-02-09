@extends('admin.layouts.app')

@push('styles')
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css" rel="stylesheet">
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
                    <li class="breadcrumb-item active" aria-current="page">{{ $title ?? '' }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-xl-3">
                    <div id="table_config_filter" class="position-relative">
                        <input type="search" id="search-box" class="form-control ps-5" aria-controls="table_config"
                            placeholder="Search Proposal..." />
                        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- notifikasi --}}
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

    @if (count($datas) > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table_config" class="table align-middle text-nowrap">
                        <thead class="header-item">
                            <tr>
                                <th>Ranking</th>
                                <th>Organisasi</th>
                                <th>Jenis</th>
                                <th>Nama Kegiatan</th>
                                <th>Relevansi Kegiatan</th>
                                <th>Skala Kegiatan</th>
                                <th>Status Pengajuan</th>
                                <th>Total Poin</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $index => $proposal)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $proposal->organisasi->user->name }}</td>
                                    <td>{{ $proposal->jenis }}</td>
                                    <td>{{ $proposal->nama_kegiatan }}</td>
                                    <td>{{ Str::limit($proposal->relevansi, 50) }}</td>
                                    <td>{{ ucfirst($proposal->skala_kegiatan) }}</td>
                                    <td>{{ ucfirst($proposal->status_pengajuan) }}</td>
                                    <td>{{ $proposal->total_poin }}</td>
                                    <td>{{ \Carbon\Carbon::parse($proposal->tanggal_pelaksanaan)->diffInDays(\Carbon\Carbon::parse($proposal->tanggal_pengajuan)) }} Hari</td>


                                    <td>{{ $proposal->status ? 'Diterima' : 'Belum Diterima' }}</td>

                                    <td>

                                        <form action="{{ route('admin.' . $active . '.terima', $proposal->id) }}"
                                            method="post" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="ti ti-check"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="alert alert-warning mb-0" role="alert">
                    <div class="d-flex gap-2 align-items-center">
                        <span
                            class="rounded-circle px-1 py-0 border border-2 border-warning text-light bg-warning mb-0 d-block"
                            style="font-size: 16px;">
                            <i class="ti ti-alert-circle"></i>
                        </span>
                        <p class="mb-0">
                            No proposal data yet. <a href="{{ route('admin.' . $active . '.create') }}">Add</a> now.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script>

    <script>
        dTable = $("#table_config").DataTable({
            "dom": "lrtip"
        });

        $("#search-box").keyup(function() {
            dTable.search($(this).val()).draw();
        });
    </script>
@endpush
