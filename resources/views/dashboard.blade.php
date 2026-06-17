@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Page Header + Quick Actions --}}
<div class="page-header">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div>
            <h2 class="mb-1">Dashboard</h2>
            <p class="mb-0">Selamat datang kembali, <strong>{{ auth()->user()->nama ?? 'Mahasiswa' }}</strong> — hari ini {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="quick-actions">
            <a href="{{ route('jadwal.create') }}" class="qa-btn qa-blue">
                <i class="bi bi-calendar-plus"></i>
                <span>Tambah Jadwal</span>
            </a>
            <a href="{{ route('tugas.create') }}" class="qa-btn qa-orange">
                <i class="bi bi-journal-plus"></i>
                <span>Tambah Tugas</span>
            </a>
            <a href="{{ route('catatan.create') }}" class="qa-btn qa-purple">
                <i class="bi bi-sticky"></i>
                <span>Tambah Catatan</span>
            </a>
            <a href="{{ route('reminder.create') }}" class="qa-btn qa-red">
                <i class="bi bi-bell"></i>
                <span>Tambah Reminder</span>
            </a>
        </div>
    </div>
</div>

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-card-info">
                    <div class="stat-label">Jadwal Kuliah</div>
                    <div class="stat-value">{{ $totalJadwal }}</div>
                    <div class="stat-sub">mata kuliah aktif</div>
                </div>
                <div class="stat-icon-wrap stat-blue">
                    <i class="bi bi-calendar-week"></i>
                </div>
            </div>
            <div class="stat-accent-line" style="background:linear-gradient(90deg,#2563EB,#60A5FA)"></div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-card-info">
                    <div class="stat-label">Total Tugas</div>
                    <div class="stat-value">{{ $totalTugas }}</div>
                    <div class="stat-sub">{{ $tugasSelesai ?? 0 }} selesai</div>
                </div>
                <div class="stat-icon-wrap stat-orange">
                    <i class="bi bi-journal-check"></i>
                </div>
            </div>
            <div class="stat-accent-line" style="background:linear-gradient(90deg,#F97316,#FB923C)"></div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-card-info">
                    <div class="stat-label">Catatan</div>
                    <div class="stat-value">{{ $totalCatatan }}</div>
                    <div class="stat-sub">tersimpan</div>
                </div>
                <div class="stat-icon-wrap stat-purple">
                    <i class="bi bi-sticky"></i>
                </div>
            </div>
            <div class="stat-accent-line" style="background:linear-gradient(90deg,#7C3AED,#A78BFA)"></div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-card-info">
                    <div class="stat-label">Reminder Aktif</div>
                    <div class="stat-value">{{ $totalReminder }}</div>
                    <div class="stat-sub">pengingat</div>
                </div>
                <div class="stat-icon-wrap stat-red">
                    <i class="bi bi-bell"></i>
                </div>
            </div>
            <div class="stat-accent-line" style="background:linear-gradient(90deg,#EF4444,#F87171)"></div>
        </div>
    </div>
</div>

{{-- Notifikasi Akademik Widget --}}
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="card-title mb-0">
                    <i class="bi bi-bell-fill" style="color:var(--orange)"></i>
                    Notifikasi Akademik
                </div>
                <a href="#" class="notif-widget-see-all" id="widgetSeeAll">Lihat Semua</a>
            </div>
            <div id="notifWidget">
                <div class="d-flex align-items-center justify-content-center py-4 gap-2" style="color:var(--text-muted);font-size:13px">
                    <div class="spinner-border spinner-border-sm text-primary"></div> Memuat notifikasi...
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Progress Tugas --}}
@if($totalTugas > 0)
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="card-title mb-0">
                    <i class="bi bi-bar-chart-line" style="color:var(--orange)"></i>
                    Progress Akademik
                </div>
                <span class="tag-badge tag-orange">{{ round(($tugasSelesai / $totalTugas) * 100) }}% selesai</span>
            </div>
            <div class="d-flex justify-content-between mb-2" style="font-size:13px">
                <span style="color:var(--text-muted);font-weight:500">Tugas Selesai</span>
                <span style="color:var(--orange);font-weight:700">{{ $tugasSelesai }} / {{ $totalTugas }}</span>
            </div>
            <div class="progress-track" style="height:10px">
                <div class="progress-fill" style="width:{{ round(($tugasSelesai / $totalTugas) * 100) }}%"></div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Charts --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-lg-4">
        <div class="dashboard-card h-100">
            <div class="card-title"><i class="bi bi-pie-chart" style="color:var(--primary)"></i>Status Tugas</div>
            <div style="position:relative;height:210px">
                <div id="pie-skeleton" class="d-flex align-items-center justify-content-center h-100 gap-2" style="color:var(--text-muted);font-size:13px">
                    <div class="spinner-border spinner-border-sm text-primary"></div> Memuat...
                </div>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="dashboard-card h-100">
            <div class="card-title"><i class="bi bi-bar-chart" style="color:var(--orange)"></i>Tugas per Bulan</div>
            <div style="position:relative;height:210px">
                <div id="tugas-bar-skeleton" class="d-flex align-items-center justify-content-center h-100 gap-2" style="color:var(--text-muted);font-size:13px">
                    <div class="spinner-border spinner-border-sm" style="color:var(--orange)"></div> Memuat...
                </div>
                <canvas id="tugasBarChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-title"><i class="bi bi-bell" style="color:var(--danger)"></i>Reminder per Bulan</div>
            <div style="position:relative;height:180px">
                <div id="reminder-bar-skeleton" class="d-flex align-items-center justify-content-center h-100 gap-2" style="color:var(--text-muted);font-size:13px">
                    <div class="spinner-border spinner-border-sm text-warning"></div> Memuat...
                </div>
                <canvas id="reminderBarChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Jadwal & Tugas row --}}
<div class="row g-3 mb-3">
    <div class="col-12 col-lg-6">
        <div class="dashboard-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="card-title mb-0">
                    <i class="bi bi-clock" style="color:var(--primary)"></i>
                    Jadwal Hari Ini
                </div>
                <a href="{{ route('jadwal.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
            </div>
            @forelse($jadwalHariIni as $item)
                <div class="class-item">
                    <div class="class-item-header">
                        <span class="class-item-subject">{{ $item->mata_kuliah }}</span>
                        <span class="class-item-time"><i class="bi bi-clock me-1"></i>{{ substr($item->jam_mulai,0,5) }} – {{ substr($item->jam_selesai,0,5) }}</span>
                    </div>
                    <div class="class-item-details">
                        <span><i class="bi bi-person me-1"></i>{{ $item->dosen }}</span>
                        <span><i class="bi bi-door-open me-1"></i>{{ $item->ruangan }}</span>
                        <span class="tag-badge tag-blue">{{ $item->hari }}</span>
                    </div>
                </div>
            @empty
                <div class="empty-state" style="padding:32px 16px">
                    <div class="empty-state-icon" style="width:48px;height:48px;font-size:22px"><i class="bi bi-calendar-check"></i></div>
                    <p style="font-size:13px;margin:0">Tidak ada jadwal hari ini.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="dashboard-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="card-title mb-0">
                    <i class="bi bi-journal-bookmark" style="color:var(--orange)"></i>
                    Tugas Mendatang
                </div>
                <a href="{{ route('tugas.index') }}" class="btn btn-sm" style="color:var(--orange);border:1px solid rgba(249,115,22,0.35);border-radius:8px;font-size:12px;font-weight:600;padding:4px 12px">Lihat Semua</a>
            </div>
            @forelse($tugasMendatang as $item)
                <div class="deadline-item">
                    <div class="deadline-text">
                        <div style="color:var(--text);font-weight:600;font-size:14px;margin-bottom:3px">{{ $item->judul }}</div>
                        <div style="font-size:12px;color:var(--text-muted)">Progress: {{ $item->progress }}%</div>
                        <div class="progress-track mt-1" style="height:5px;max-width:200px">
                            <div class="progress-fill" style="width:{{ $item->progress }}%"></div>
                        </div>
                    </div>
                    <span class="tag-badge tag-orange" style="white-space:nowrap;flex-shrink:0">
                        {{ \Carbon\Carbon::parse($item->deadline)->translatedFormat('d M Y') }}
                    </span>
                </div>
            @empty
                <div class="empty-state" style="padding:32px 16px">
                    <div class="empty-state-icon" style="width:48px;height:48px;font-size:22px"><i class="bi bi-check-circle"></i></div>
                    <p style="font-size:13px;margin:0">Tidak ada tugas mendatang.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Reminder & Catatan row --}}
<div class="row g-3">
    <div class="col-12 col-lg-6">
        <div class="dashboard-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="card-title mb-0">
                    <i class="bi bi-bell" style="color:var(--danger)"></i>
                    Reminder Aktif
                </div>
                <a href="{{ route('reminder.index') }}" class="btn btn-sm" style="color:var(--danger);border:1px solid rgba(239,68,68,0.35);border-radius:8px;font-size:12px;font-weight:600;padding:4px 12px">Lihat Semua</a>
            </div>
            @forelse($reminderAktif as $item)
                <div class="reminder-item">
                    <div style="text-align:center;min-width:58px">
                        <div class="tag-badge tag-red" style="font-size:12px;padding:4px 8px">{{ \Carbon\Carbon::parse($item->reminder_date)->format('H:i') }}</div>
                        <div style="font-size:11px;color:var(--text-muted);margin-top:3px">{{ \Carbon\Carbon::parse($item->reminder_date)->translatedFormat('d M') }}</div>
                    </div>
                    <div>
                        <div style="color:var(--text);font-weight:600;font-size:14px">{{ $item->tugas->judul ?? '-' }}</div>
                        <div style="font-size:12px;color:var(--text-muted)">{{ \Carbon\Carbon::parse($item->reminder_date)->translatedFormat('l, d M Y') }}</div>
                    </div>
                </div>
            @empty
                <div class="empty-state" style="padding:32px 16px">
                    <div class="empty-state-icon" style="width:48px;height:48px;font-size:22px"><i class="bi bi-bell-slash"></i></div>
                    <p style="font-size:13px;margin:0">Tidak ada reminder aktif.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="dashboard-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="card-title mb-0">
                    <i class="bi bi-sticky" style="color:#7C3AED"></i>
                    Catatan Terbaru
                </div>
                <a href="{{ route('catatan.index') }}" class="btn btn-sm" style="color:#7C3AED;border:1px solid rgba(124,58,237,0.35);border-radius:8px;font-size:12px;font-weight:600;padding:4px 12px">Lihat Semua</a>
            </div>
            @forelse($catatanTerbaru as $item)
                <div class="checklist-item">
                    <div style="flex:1;min-width:0">
                        <div style="color:var(--text);font-weight:600;font-size:14px;margin-bottom:2px">{{ $item->judul }}</div>
                        <div style="font-size:12px;color:var(--text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ \Illuminate\Support\Str::limit($item->isi, 60) }}</div>
                    </div>
                    <a href="{{ route('catatan.show', $item) }}" class="btn btn-outline-secondary btn-sm ms-2">
                        <i class="bi bi-eye"></i>
                    </a>
                </div>
            @empty
                <div class="empty-state" style="padding:32px 16px">
                    <div class="empty-state-icon" style="width:48px;height:48px;font-size:22px"><i class="bi bi-pencil"></i></div>
                    <p style="font-size:13px;margin:0">Belum ada catatan.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

@section('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <style>
        /* ═══ Notifikasi Widget ═══ */
        .notif-widget-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 0;
            border-bottom: 1px solid var(--border);
            text-decoration: none;
            color: inherit;
            transition: all var(--transition);
        }
        .notif-widget-item:last-child { border-bottom: none; }
        .notif-widget-item:hover { opacity: 0.8; }
        .notif-widget-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .notif-widget-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; flex-shrink: 0;
        }
        .notif-widget-info { flex: 1; min-width: 0; }
        .notif-widget-title {
            font-size: 13px; font-weight: 600; color: var(--text);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .notif-widget-sub {
            font-size: 11px; color: var(--text-muted); margin-top: 1px;
        }
        .notif-widget-see-all {
            font-size: 12px; font-weight: 600;
            color: var(--primary); text-decoration: none;
            transition: color var(--transition);
        }
        .notif-widget-see-all:hover { color: var(--primary-light); }

        /* ═══ Quick Actions ═══ */
        .quick-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .qa-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid transparent;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        .qa-btn i { font-size: 15px; }
        .qa-btn:hover {
            transform: translateY(-2px);
        }
        .qa-blue {
            background: rgba(37,99,235,0.07);
            color: var(--primary);
            border-color: rgba(37,99,235,0.18);
        }
        .qa-blue:hover {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 4px 14px rgba(37,99,235,0.3);
            border-color: var(--primary);
        }
        .qa-orange {
            background: rgba(249,115,22,0.07);
            color: var(--orange);
            border-color: rgba(249,115,22,0.18);
        }
        .qa-orange:hover {
            background: var(--orange);
            color: #fff;
            box-shadow: 0 4px 14px rgba(249,115,22,0.3);
            border-color: var(--orange);
        }
        .qa-purple {
            background: rgba(124,58,237,0.07);
            color: #7C3AED;
            border-color: rgba(124,58,237,0.18);
        }
        .qa-purple:hover {
            background: #7C3AED;
            color: #fff;
            box-shadow: 0 4px 14px rgba(124,58,237,0.3);
            border-color: #7C3AED;
        }
        .qa-red {
            background: rgba(239,68,68,0.07);
            color: var(--danger);
            border-color: rgba(239,68,68,0.18);
        }
        .qa-red:hover {
            background: var(--danger);
            color: #fff;
            box-shadow: 0 4px 14px rgba(239,68,68,0.3);
            border-color: var(--danger);
        }
        @media (max-width: 576px) {
            .quick-actions {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 8px;
                width: 100%;
            }
            .qa-btn {
                justify-content: center;
                padding: 11px 10px;
            }
        }
    </style>
@endsection

@section('scripts')
<script>
(function () {
    const cssVar = (n) => getComputedStyle(document.documentElement).getPropertyValue(n).trim();
    const isDark = () => document.documentElement.getAttribute('data-theme') === 'dark';

    const C = {
        primary:  '#2563EB',
        blue:     '#60A5FA',
        orange:   '#F97316',
        success:  '#22C55E',
        danger:   '#EF4444',
        warning:  '#F59E0B',
        text:     () => cssVar('--text')       || (isDark() ? '#F9FAFB' : '#1E293B'),
        muted:    () => cssVar('--text-muted')  || (isDark() ? '#D1D5DB' : '#64748B'),
        border:   () => cssVar('--border')      || (isDark() ? '#4B5563' : '#E2E8F0'),
        card:     () => cssVar('--card-bg')     || (isDark() ? '#374151' : '#FFFFFF'),
    };

    /* ── Notification Widget ── */
    (function() {
        var widget = document.getElementById('notifWidget');
        var seeAll = document.getElementById('widgetSeeAll');
        var toggle = document.getElementById('notifToggle');
        var apiUrl = '{{ route("notifications.index") }}';

        seeAll.addEventListener('click', function(e) {
            e.preventDefault();
            if (toggle) toggle.click();
        });

        fetch(apiUrl)
            .then(function(r) { return r.json(); })
            .then(function(data) {
                var items = data.latest_five;
                if (!items || !items.length) {
                    widget.innerHTML = '<div class="d-flex flex-column align-items-center py-4" style="color:var(--text-muted)">' +
                        '<i class="bi bi-bell-slash" style="font-size:28px;opacity:0.4;margin-bottom:8px"></i>' +
                        '<p style="font-size:13px;margin:0">Tidak ada notifikasi saat ini.</p></div>';
                    return;
                }
                widget.innerHTML = items.map(function(n) {
                    return '<a href="' + n.url + '" class="notif-widget-item">' +
                        '<div class="notif-widget-icon" style="background:' + n.color + '18;color:' + n.color + '">' +
                            '<i class="bi ' + n.icon + '"></i>' +
                        '</div>' +
                        '<div class="notif-widget-info">' +
                            '<div class="notif-widget-title">' + n.label + ' — ' + n.title + '</div>' +
                            '<div class="notif-widget-sub">' + n.time_ago + '</div>' +
                        '</div>' +
                    '</a>';
                }).join('');
            })
            .catch(function() {
                widget.innerHTML = '<div class="d-flex align-items-center justify-content-center py-4" style="color:var(--danger);font-size:13px"><i class="bi bi-exclamation-triangle me-2"></i>Gagal memuat notifikasi.</div>';
            });
    })();

    Chart.defaults.font.family      = "'Inter', sans-serif";
    Chart.defaults.font.size        = 12;
    Chart.defaults.color            = C.muted();
    Chart.defaults.borderColor      = C.border();
    Chart.defaults.responsive       = true;
    Chart.defaults.maintainAspectRatio = false;
    Chart.defaults.plugins.legend.labels.usePointStyle = true;

    fetch('{{ route("dashboard.chart-data") }}')
        .then(r => r.json())
        .then(data => {
            renderPie(data.pie);
            renderTugasBar(data.tugasMonthly, data.monthLabels, data.year);
            renderReminderBar(data.reminderMonthly, data.monthLabels, data.year);
        })
        .catch(() => {
            document.querySelectorAll('[id$="-skeleton"]').forEach(el => {
                el.innerHTML = '<span style="color:#EF4444"><i class="bi bi-exclamation-triangle me-1"></i>Gagal memuat data.</span>';
            });
        });

    function renderPie(pie) {
        document.getElementById('pie-skeleton').remove();
        const hasData = (pie.completed + pie.incomplete) > 0;
        new Chart(document.getElementById('pieChart'), {
            type: 'doughnut',
            data: {
                labels: ['Selesai', 'Belum Selesai'],
                datasets: [{
                    data: hasData ? [pie.completed, pie.incomplete] : [1],
                    backgroundColor: hasData ? [C.success, C.danger] : [C.border],
                    borderWidth: 0,
                    hoverOffset: 6,
                }],
            },
            options: {
                cutout: '65%',
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 16, font: { size: 12 } } },
                    tooltip: {
                        enabled: hasData,
                        callbacks: {
                            label(ctx) {
                                const total = ctx.dataset.data.reduce((a,b) => a+b, 0);
                                return `${ctx.label}: ${ctx.raw} (${Math.round(ctx.raw/total*100)}%)`;
                            }
                        }
                    }
                }
            },
            plugins: [{
                id: 'centre',
                afterDraw(chart) {
                    if (!hasData) return;
                    const { ctx, chartArea } = chart;
                    const total = pie.completed + pie.incomplete;
                    const pct = Math.round(pie.completed / total * 100);
                    const cx = chartArea.left + chartArea.width / 2;
                    const cy = chartArea.top + chartArea.height / 2;
                    ctx.save();
                    ctx.font = 'bold 20px Inter,sans-serif';
                    ctx.fillStyle = C.text();
                    ctx.textAlign = 'center';
                    ctx.fillText(pct + '%', cx, cy);
                    ctx.font = '11px Inter,sans-serif';
                    ctx.fillStyle = C.muted();
                    ctx.fillText('Selesai', cx, cy + 16);
                    ctx.restore();
                }
            }]
        });
    }

    function renderTugasBar(monthly, labels, year) {
        document.getElementById('tugas-bar-skeleton').remove();
        new Chart(document.getElementById('tugasBarChart'), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: `Tugas ${year}`,
                    data: monthly,
                    backgroundColor: 'rgba(249,115,22,0.7)',
                    borderColor: '#F97316',
                    borderWidth: 1,
                    borderRadius: 6,
                    maxBarThickness: 30,
                }],
            },
            options: barOpts(`Tugas dibuat per bulan — ${year}`),
        });
    }

    function renderReminderBar(monthly, labels, year) {
        document.getElementById('reminder-bar-skeleton').remove();
        new Chart(document.getElementById('reminderBarChart'), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: `Reminder ${year}`,
                    data: monthly,
                    backgroundColor: 'rgba(37,99,235,0.65)',
                    borderColor: '#2563EB',
                    borderWidth: 1,
                    borderRadius: 6,
                    maxBarThickness: 30,
                }],
            },
            options: barOpts(`Reminder per bulan — ${year}`),
        });
    }

    function barOpts(subtitle) {
        return {
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: C.card(),
                    borderColor: C.border(),
                    borderWidth: 1,
                    titleColor: C.text(),
                    bodyColor: C.muted(),
                    padding: 10,
                    cornerRadius: 8,
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { color: C.muted() } },
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, color: C.muted() },
                    grid: { color: isDark() ? 'rgba(75,85,99,0.4)' : 'rgba(226,232,240,0.6)' }
                }
            }
        };
    }
})();
</script>
@endsection
