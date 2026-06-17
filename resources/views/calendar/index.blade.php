@extends('layouts.app')

@section('title', 'Kalender Akademik')

@section('content')
    {{-- Page Header --}}
    <div class="page-header d-flex flex-wrap justify-content-between align-items-start gap-2">
        <div>
            <h2><i class="bi bi-calendar3 me-2"></i>Kalender Akademik</h2>
            <p>Lihat semua jadwal kuliah, tugas, dan reminder dalam satu tampilan kalender.</p>
        </div>

        {{-- Legend --}}
        <div class="d-flex gap-3 flex-wrap mt-1">
            <span class="cal-legend"><span class="cal-dot" style="background:#06B6D4"></span> Jadwal</span>
            <span class="cal-legend"><span class="cal-dot" style="background:#EF4444"></span> Tugas</span>
            <span class="cal-legend"><span class="cal-dot" style="background:#F59E0B"></span> Reminder</span>
        </div>
    </div>

    {{-- Calendar Card --}}
    <div class="dashboard-card p-0 overflow-hidden">
        <div id="calendar" class="p-3"></div>
    </div>

    {{-- Event Detail Modal --}}
    <div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content cal-modal">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" id="eventModalTitle"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-2">
                    <div id="eventModalBody"></div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    {{-- FullCalendar v5 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.css">

    <style>
        /* ── Legend ─────────────────────────────────────────── */
        .cal-legend {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
        }
        .cal-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }

        /* ── Modal ─────────────────────────────────────────── */
        .cal-modal {
            background-color: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            color: var(--text);
        }
        .cal-modal .modal-title {
            font-weight: 700;
            font-size: 18px;
            color: var(--text);
        }
        .cal-modal .btn-outline-secondary {
            border-color: var(--border);
            color: var(--text-muted);
        }
        .cal-modal .btn-outline-secondary:hover {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .detail-row {
            display: flex;
            gap: 8px;
            padding: 8px 0;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
        }
        .detail-row:last-child { border-bottom: none; }
        .detail-label {
            font-weight: 600;
            min-width: 110px;
            color: var(--text-muted);
        }
        .detail-value { color: var(--text); flex: 1; }

        .type-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .type-badge.jadwal { background: rgba(6,182,212,0.15); color: #06B6D4; }
        .type-badge.tugas  { background: rgba(239,68,68,0.15);  color: #F87171; }
        .type-badge.reminder { background: rgba(245,158,11,0.15); color: #FBBF24; }

        /* ── FullCalendar overrides ────────────────────────── */
        #calendar {
            --fc-border-color: var(--border);
            --fc-page-bg-color: transparent;
            --fc-neutral-bg-color: rgba(96,165,250,0.04);
            --fc-today-bg-color: rgba(96,165,250,0.08);
            --fc-event-text-color: #fff;
        }

        .fc-theme-standard .fc-scrollgrid,
        .fc-theme-standard td,
        .fc-theme-standard th {
            border-color: var(--border) !important;
        }

        .fc .fc-col-header-cell-cushion,
        .fc .fc-daygrid-day-number {
            color: var(--text-muted);
            text-decoration: none;
        }

        .fc .fc-button-primary {
            background-color: var(--card-bg);
            border-color: var(--border);
            color: var(--text);
            font-size: 13px;
        }
        .fc .fc-button-primary:hover,
        .fc .fc-button-primary:not(:disabled):active,
        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }
        .fc .fc-button-primary:focus,
        .fc .fc-button-primary:not(:disabled):focus {
            box-shadow: 0 0 0 0.2rem rgba(96,165,250,0.25);
        }

        .fc .fc-toolbar-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
        }

        .fc .fc-daygrid-day.fc-day-today {
            background-color: rgba(96,165,250,0.08) !important;
        }

        .fc .fc-daygrid-event {
            border-radius: 6px;
            padding: 1px 4px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
        }
        .fc .fc-daygrid-event:hover { opacity: 0.85; }

        .fc .fc-timegrid-event {
            border-radius: 6px;
            padding: 2px 4px;
            font-size: 12px;
            cursor: pointer;
        }

        .fc .fc-daygrid-day-top { flex-direction: row; }

        .fc .fc-daygrid-more-link {
            color: var(--primary);
            font-weight: 600;
        }

        .fc .fc-timegrid-axis-cushion,
        .fc .fc-timegrid-slot-label-cushion {
            color: var(--text-muted);
            font-size: 12px;
        }

        .fc .fc-popover {
            background-color: var(--card-bg);
            border-color: var(--border);
        }
        .fc .fc-popover-header {
            background-color: var(--sidebar-bg);
            color: var(--text);
        }
        .fc .fc-popover-body { background-color: var(--card-bg); }

        .cal-loading {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
            color: var(--text-muted);
            font-size: 15px;
            gap: 10px;
        }
    </style>
@endsection

@section('scripts')
    {{-- FullCalendar v5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/locales-all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView : 'dayGridMonth',
                locale      : 'id',
                firstDay    : 1,
                height      : 'auto',
                headerToolbar: {
                    left  : 'prev,next today',
                    center: 'title',
                    right : 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                },
                buttonText: {
                    today    : 'Hari Ini',
                    month    : 'Bulan',
                    week     : 'Minggu',
                    day      : 'Hari',
                    list     : 'Daftar',
                },

                // Event sources (fetched from backend)
                eventSources: [
                    {
                        url        : '{{ route("calendar.events") }}',
                        method     : 'GET',
                        failure    : () => alert('Gagal memuat event kalender.'),
                    },
                ],

                loading(isLoading) {
                    // Optional: show/hide loader
                },

                // ── Click event → open modal ────────────────
                eventClick(info) {
                    info.jsEvent.preventDefault();

                    const ev   = info.event;
                    const ext  = ev.extendedProps;
                    const title = ev.title;
                    const type  = ext.type || '-';

                    // Build modal body
                    let html = '';

                    // Type badge
                    const badgeClass = type.toLowerCase().includes('jadwal') ? 'jadwal'
                                     : type.toLowerCase().includes('tugas') ? 'tugas'
                                     : 'reminder';
                    html += `<span class="type-badge ${badgeClass} mb-3 d-inline-block">${type}</span>`;

                    if (badgeClass === 'jadwal') {
                        html += row('Mata Kuliah', title);
                        html += row('Hari',        ext.hari);
                        html += row('Waktu',       ext.jam_mulai + ' – ' + ext.jam_selesai);
                        html += row('Dosen',       ext.dosen);
                        html += row('Ruangan',     ext.ruangan);
                    } else if (badgeClass === 'tugas') {
                        html += row('Judul Tugas', title);
                        html += row('Deadline',    ext.deadline);
                        html += row('Progress',    ext.progress);
                        html += row('Status',      ext.status);
                        if (ext.deskripsi) {
                            html += row('Deskripsi', ext.deskripsi);
                        }
                    } else {
                        // Reminder
                        html += row('Reminder untuk', ext.tugas);
                        html += row('Tanggal',        ext.reminder_date);
                        html += row('Status',         ext.status);
                    }

                    document.getElementById('eventModalTitle').textContent = title;
                    document.getElementById('eventModalBody').innerHTML    = html;

                    new bootstrap.Modal(document.getElementById('eventModal')).show();
                },
            });

            calendar.render();

            /**
             * Helper to build a detail row.
             */
            function row(label, value) {
                return `<div class="detail-row">
                            <span class="detail-label">${label}</span>
                            <span class="detail-value">${value || '-'}</span>
                        </div>`;
            }
        });
    </script>
@endsection
