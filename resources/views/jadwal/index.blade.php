@extends('layouts.app')

@section('title', 'Jadwal Kuliah')

@section('content')

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2>Jadwal Kuliah</h2>
            <p>Kelola jadwal mata kuliah kamu</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('jadwal.export-pdf') }}" class="btn btn-danger" target="_blank">
                <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
            </a>
            <a href="{{ route('jadwal.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Tambah Jadwal
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Filter --}}
<form action="{{ route('jadwal.index') }}" method="GET" class="filter-bar">
    <div class="search-group">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari mata kuliah, dosen, ruangan..." autocomplete="off">
    </div>
    <select name="hari" onchange="this.form.submit()">
        <option value="" @selected(!request('hari'))>Semua Hari</option>
        @foreach($hariList as $h)
            <option value="{{ $h }}" @selected(request('hari') === $h)>{{ $h }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-secondary-grad" style="padding:8px 16px;font-size:13px">
        <i class="bi bi-search"></i>
    </button>
    @if(request()->hasAny(['search', 'hari']))
        <a href="{{ route('jadwal.index') }}" class="btn-reset"><i class="bi bi-x-lg"></i>Reset</a>
    @endif
</form>

<div class="dashboard-card">
    @forelse($jadwal as $item)
        <div class="class-item">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div style="flex:1;min-width:0">
                    <div class="class-item-header">
                        <span class="class-item-subject">{{ $item->mata_kuliah }}</span>
                        <span class="class-item-time">
                            <i class="bi bi-clock me-1"></i>{{ substr($item->jam_mulai,0,5) }} – {{ substr($item->jam_selesai,0,5) }}
                        </span>
                    </div>
                    <div class="class-item-details">
                        <span><i class="bi bi-person me-1"></i>{{ $item->dosen }}</span>
                        <span><i class="bi bi-door-open me-1"></i>{{ $item->ruangan }}</span>
                        <span class="tag-badge tag-blue">{{ $item->hari }}</span>
                    </div>
                </div>
                <div class="d-flex gap-2 flex-shrink-0">
                    <a href="{{ route('jadwal.edit', $item) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form action="{{ route('jadwal.destroy', $item) }}" method="POST"
                          onsubmit="return confirm('Hapus jadwal ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-calendar-x"></i></div>
            @if(request()->hasAny(['search', 'hari']))
                <h5>Tidak ada hasil</h5>
                <p>Tidak ada jadwal yang cocok dengan filter.</p>
                <a href="{{ route('jadwal.index') }}" class="btn btn-outline-primary btn-sm mt-2">Reset Filter</a>
            @else
                <h5>Belum ada jadwal</h5>
                <p>Mulai tambahkan jadwal mata kuliah kamu.</p>
                <a href="{{ route('jadwal.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Jadwal
                </a>
            @endif
        </div>
    @endforelse
</div>

@if($jadwal->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $jadwal->links('pagination::bootstrap-5') }}
    </div>
@endif

@endsection
