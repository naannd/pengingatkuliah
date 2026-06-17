@extends('layouts.app')

@section('title', 'Reminder')

@section('content')

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2>Reminder</h2>
            <p>Atur pengingat untuk deadline dan jadwal penting</p>
        </div>
        <a href="{{ route('reminder.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Reminder
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('reminder.index') }}" method="GET" class="filter-bar">
    <div class="search-group">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari berdasarkan judul tugas..." autocomplete="off">
    </div>
    <button type="submit" class="btn btn-outline-primary">
        <i class="bi bi-search me-1"></i>Cari
    </button>
    @if(request('search'))
        <a href="{{ route('reminder.index') }}" class="btn-reset"><i class="bi bi-x-lg"></i>Reset</a>
    @endif
</form>

<div class="dashboard-card">
    @forelse($reminder as $item)
        <div class="reminder-item justify-content-between">
            <div class="d-flex align-items-center gap-3">
                {{-- Time badge --}}
                <div style="text-align:center;min-width:68px;flex-shrink:0">
                    <div class="tag-badge tag-blue" style="font-size:13px;font-weight:700;padding:5px 10px;display:block;text-align:center">
                        {{ \Carbon\Carbon::parse($item->reminder_date)->format('H:i') }}
                    </div>
                    <div style="font-size:11px;color:var(--text-muted);margin-top:4px;font-weight:500">
                        {{ \Carbon\Carbon::parse($item->reminder_date)->translatedFormat('d M') }}
                    </div>
                </div>
                {{-- Info --}}
                <div>
                    <div style="font-weight:600;color:var(--text);font-size:14px;margin-bottom:3px">
                        {{ $item->tugas->judul ?? '-' }}
                    </div>
                    <div style="font-size:12px;color:var(--text-muted)">
                        <i class="bi bi-calendar me-1"></i>
                        {{ \Carbon\Carbon::parse($item->reminder_date)->translatedFormat('l, d M Y, H:i') }}
                    </div>
                </div>
            </div>
            {{-- Actions --}}
            <div class="d-flex align-items-center gap-2 ms-3 flex-shrink-0">
                @if($item->status === 'Aktif')
                    <span class="tag-badge tag-green">Aktif</span>
                @else
                    <span class="tag-badge" style="background:rgba(100,116,139,0.1);color:var(--text-muted)">Nonaktif</span>
                @endif
                <a href="{{ route('reminder.edit', $item) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('reminder.destroy', $item) }}" method="POST"
                      onsubmit="return confirm('Hapus reminder ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-bell-slash"></i></div>
            @if(request('search'))
                <h5>Tidak ada hasil</h5>
                <p>Tidak ada reminder yang cocok dengan pencarian.</p>
                <a href="{{ route('reminder.index') }}" class="btn btn-outline-primary btn-sm mt-2">Reset Pencarian</a>
            @else
                <h5>Belum ada reminder</h5>
                <p>Tambahkan pengingat untuk deadline tugasmu.</p>
                <a href="{{ route('reminder.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Reminder
                </a>
            @endif
        </div>
    @endforelse
</div>

@if($reminder->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $reminder->links('pagination::bootstrap-5') }}
    </div>
@endif

@endsection
