@extends('admin.layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.css" rel="stylesheet" />
    <style>
        /* Calendar Container Styling */
        #calendar {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        /* Modal Customization */
        .modal-content {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .modal-body {
            padding: 20px;
        }

        /* Event Customization */
        .fc-event {
            border-radius: 5px;
            color: #fff;
        }

        .fc-event:hover {
            opacity: 0.8;
        }

        /* Hover Effect for Event List */
        .event-list-item {
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .event-list-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        /* Modal Scrollable */
        .modal-body {
            max-height: 400px;
            overflow-y: auto;
        }

        /* Legend Styling */
        .legend-box {
            display: inline-block;
            width: 15px;
            height: 15px;
            margin-right: 10px;
            border-radius: 3px;
            vertical-align: middle;
        }


        /* Card container styling for activities */
        .activity-card {
            max-height: 80vh;
            overflow-y: auto;
        }

        /* Style for the selected date */
        .selected-date {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Styles for different types of events (card color change) */
        .nasional {
            background-color: #FF6F61;
            /* Redish color for nasional */
            color: white;
        }

        .provinsi {
            background-color: #28a745;
            /* Greenish color for provinsi */
            color: white;
        }

        .daerah {
            background-color: #007bff;
            /* Blueish color for daerah */
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Card Total Proposal -->
            <div class="col-md-4">
                <div class="card shadow-lg border-0 text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Proposal</h5>
                                <h2>{{ $proposal }}</h2>
                            </div>
                            <i class="fas fa-file-alt fa-3x"></i> <!-- Ikon Proposal -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Total Kegiatan -->
            <div class="col-md-4">
                <div class="card shadow-lg border-0 text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Kegiatan</h5>
                                <h2>{{ $kegiatan }}</h2>
                            </div>
                            <i class="fas fa-calendar-alt fa-3x"></i> <!-- Ikon Kegiatan -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Total Laporan -->
            <div class="col-md-4">
                <div class="card shadow-lg border-0 text-white bg-danger">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Laporan</h5>
                                <h2>{{ $laporan }}</h2>
                            </div>
                            <i class="fas fa-file-invoice fa-3x"></i> <!-- Ikon Laporan -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Total Proposal -->
            <div class="col-md-4">
                <div class="card shadow-lg border-0 text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Kegiatan Nasional</h5>
                                <h2>{{ $nasional }}</h2>
                            </div>
                            <i class="fas fa-file-alt fa-3x"></i> <!-- Ikon Proposal -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-lg border-0 text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Kegiatan Provinsi</h5>
                                <h2>{{ $provinis }}</h2>
                            </div>
                            <i class="fas fa-file-alt fa-3x"></i> <!-- Ikon Proposal -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-lg border-0 text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Total Kegiatan Daerah</h5>
                                <h2>{{ $daerah }}</h2>
                            </div>
                            <i class="fas fa-file-alt fa-3x"></i> <!-- Ikon Proposal -->
                        </div>
                    </div>
                </div>
            </div>


            <!-- Calendar Section on the Left -->
            <div class="col-lg-6 col-md-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title">Kalender Kegiatan Kepemudaan</h4>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                        <div class="mt-3">
                            <h6>Keterangan Skala Kegiatan:</h6>
                            <ul class="list-unstyled">
                                <li><span class="legend-box" style="background-color: #FF6F61;"></span> Nasional</li>
                                <li><span class="legend-box" style="background-color: #28a745;"></span> Provinsi</li>
                                <li><span class="legend-box" style="background-color: #007bff;"></span> Daerah</li>
                            </ul>
                        </div>
                    </div>

                </div>
                <!-- Legend Section -->


            </div>

            <!-- Activity List Section on the Right -->
            <div class="col-lg-6 col-md-12" id="activitySection" style="display: none;">
                <div class="card shadow-lg border-0 activity-card">
                    <div class="card-header bg-success text-white">
                        <h4 class="card-title">List Kegiatan</h4>
                    </div>
                    <div class="card-body">
                        <div id="selectedDate" class="selected-date"></div>
                        <ul id="activityList">
                            <!-- List of activities will be populated here -->
                        </ul>
                    </div>
                </div>
            </div>


        </div>

        <!-- Modal for Activity Details -->
        <div class="modal fade" id="kegiatanModal" tabindex="-1" aria-labelledby="kegiatanModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="kegiatanModalLabel">Detail Kegiatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="kegiatanDetails"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/moment@2.27.0/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function() {
            let selectedDate = ''; // Store the selected date

            // Initialize calendar
            $('#calendar').fullCalendar({
                events: @json($events), // Data event from Controller
                eventRender: function(event, element) {
                    // Customize event colors based on event type
                    if (event.skala_kegiatan === 'nasional') {
                        element.css('background-color', '#FF6F61'); // Redish color for 'nasional'
                    } else if (event.skala_kegiatan === 'provinsi') {
                        element.css('background-color', '#28a745'); // Greenish color for 'provinsi'
                    } else if (event.skala_kegiatan === 'daerah') {
                        element.css('background-color', '#007bff'); // Blueish color for 'daerah'
                    }
                    element.css('border-radius', '5px');
                },
                dayClick: function(date, jsEvent, view) {
                    // Store the selected date
                    selectedDate = date.format('YYYY-MM-DD');

                    // Display the selected date above the activity list
                    // $('#selectedDate').text(`Kegiatan untuk Tanggal: ${selectedDate}`);

                    // Filter events for the selected date
                    const filteredEvents = @json($events).filter(event => event.start ===
                        selectedDate);

                    // Show the activity list
                    $('#activitySection').show();

                    // Clear the activity list
                    $('#activityList').empty();

                    // Populate the activity list
                    filteredEvents.forEach(event => {
                        // Assign a class based on skala_kegiatan to dynamically change card color

                        const eventClass = event.skala_kegiatan.toLowerCase();
                        let activityItem;
                        if (event.jenis === 'proposal') {
                            activityItem = `
                    <li class="event-list-item ${eventClass}">
    <a href="/admin/proposal/${event.id}/show" style="text-decoration: none; color: inherit; display: block; padding: 10px;">
        <strong>Kegiatan:</strong> ${event.title} <br>
        <strong>Organisasi:</strong> ${event.organisasi} <br>
        <strong>Skala Kegiatan:</strong> ${event.skala_kegiatan} <br>
        <strong>Tanggal:</strong> ${event.start}
    </a>
</li>

                            `;
                        } else {
                            activityItem = `
                    <li class="event-list-item ${eventClass}">
    <a href="/admin/kegiatan/${event.id}/show" style="text-decoration: none; color: inherit; display: block; padding: 10px;">
        <strong>Kegiatan:</strong> ${event.title} <br>
        <strong>Organisasi:</strong> ${event.organisasi} <br>
        <strong>Skala Kegiatan:</strong> ${event.skala_kegiatan} <br>
        <strong>Tanggal:</strong> ${event.start}
    </a>
</li>

                            `;
                        }


                        $('#activityList').append(activityItem);
                    });
                }
            });
        });
    </script>
@endpush
