@extends('layouts.app')

@section('title', 'Daftar Tugas')

@section('content')

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2>Daftar Tugas</h2>
            <p>Pantau dan kelola semua tugas kuliah kamu</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('tugas.export-pdf') }}" class="btn btn-danger" target="_blank">
                <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
            </a>
            <a href="{{ route('tugas.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Tambah Tugas
            </a>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-card-info">
                    <div class="stat-label">Total</div>
                    <div class="stat-value">{{ $totalTugas }}</div>
                </div>
                <div class="stat-icon-wrap stat-blue"><i class="bi bi-journal-text"></i></div>
            </div>
            <div class="stat-accent-line" style="background:linear-gradient(90deg,#2563EB,#60A5FA)"></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-card-info">
                    <div class="stat-label">Selesai</div>
                    <div class="stat-value">{{ $selesai }}</div>
                </div>
                <div class="stat-icon-wrap stat-green"><i class="bi bi-check-circle"></i></div>
            </div>
            <div class="stat-accent-line" style="background:linear-gradient(90deg,#22C55E,#4ADE80)"></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-card-info">
                    <div class="stat-label">Belum Selesai</div>
                    <div class="stat-value">{{ $belumSelesai }}</div>
                </div>
                <div class="stat-icon-wrap stat-yellow"><i class="bi bi-hourglass-split"></i></div>
            </div>
            <div class="stat-accent-line" style="background:linear-gradient(90deg,#F59E0B,#FBBF24)"></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-card-inner">
                <div class="stat-card-info">
                    <div class="stat-label">Terlambat</div>
                    <div class="stat-value">{{ $terlambat }}</div>
                </div>
                <div class="stat-icon-wrap stat-red"><i class="bi bi-exclamation-circle"></i></div>
            </div>
            <div class="stat-accent-line" style="background:linear-gradient(90deg,#EF4444,#F87171)"></div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Filter --}}
<form action="{{ route('tugas.index') }}" method="GET" class="filter-bar">
    <div class="search-group">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tugas..." autocomplete="off">
    </div>
    <select name="status" onchange="this.form.submit()">
        <option value="" @selected(!request('status'))>Semua Status</option>
        <option value="Selesai" @selected(request('status') === 'Selesai')>Selesai</option>
        <option value="Belum Selesai" @selected(request('status') === 'Belum Selesai')>Belum Selesai</option>
    </select>
    @if(request()->hasAny(['search', 'status']))
        <a href="{{ route('tugas.index') }}" class="btn-reset"><i class="bi bi-x-lg"></i>Reset</a>
    @endif
</form>

<div class="dashboard-card">
    @forelse($tugas as $item)
        @php $overdue = $item->isOverdue(); @endphp
        <div class="deadline-item {{ $overdue ? 'ps-3' : '' }}"
             style="{{ $overdue ? 'border-left:3px solid #EF4444;margin-left:-1px' : '' }}">
            <div class="deadline-text">
                <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                    <span style="font-weight:600;color:var(--text);font-size:14px">{{ $item->judul }}</span>
                    @if($item->isSelesai())
                        <span class="tag-badge tag-green">Selesai</span>
                    @elseif($overdue)
                        <span class="tag-badge tag-red">Terlambat</span>
                    @else
                        <span class="tag-badge tag-yellow">Belum Selesai</span>
                    @endif
                </div>
                @if($item->deskripsi)
                    <div style="font-size:12px;color:var(--text-muted);margin-bottom:4px">{{ \Illuminate\Support\Str::limit($item->deskripsi, 80) }}</div>
                @endif
                <div style="font-size:12px;color:var(--text-muted)">
                    <i class="bi bi-calendar me-1"></i>
                    Deadline: {{ \Carbon\Carbon::parse($item->deadline)->translatedFormat('d M Y, H:i') }}
                    @if($overdue)
                        <span style="color:var(--danger);font-weight:600">({{ \Carbon\Carbon::parse($item->deadline)->diffForHumans() }})</span>
                    @endif
                </div>
                <div class="mt-2" style="max-width:280px">
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size:11px;color:var(--text-muted)">Progress</span>
                        <span style="font-size:11px;color:var(--orange);font-weight:700">{{ $item->progress }}%</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width:{{ $item->progress }}%"></div>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 ms-2 flex-shrink-0">
                @if(!$item->isSelesai())
                    <form action="{{ route('tugas.complete', $item) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-success btn-sm" title="Tandai Selesai">
                            <i class="bi bi-check-lg"></i>
                        </button>
                    </form>
                @endif
                <a href="{{ route('tugas.edit', $item) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('tugas.destroy', $item) }}" method="POST"
                      onsubmit="return confirm('Hapus tugas ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-journal-x"></i></div>
            @if(request()->hasAny(['search', 'status']))
                <h5>Tidak ada hasil</h5>
                <p>Tidak ada tugas yang cocok dengan filter.</p>
                <a href="{{ route('tugas.index') }}" class="btn btn-outline-primary btn-sm mt-2">Reset Filter</a>
            @else
                <h5>Belum ada tugas</h5>
                <p>Tambahkan tugas pertama kamu sekarang.</p>
                <a href="{{ route('tugas.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Tugas
                </a>
            @endif
        </div>
    @endforelse
</div>

@if($tugas->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $tugas->links('pagination::bootstrap-5') }}
    </div>
@endif

@endsection
