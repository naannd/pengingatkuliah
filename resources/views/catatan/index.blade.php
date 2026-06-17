@extends('layouts.app')

@section('title', 'Catatan')

@section('content')

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2>Catatan</h2>
            <p>Simpan dan kelola catatan perkuliahan kamu</p>
        </div>
        <a href="{{ route('catatan.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Catatan
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('catatan.index') }}" method="GET" class="filter-bar">
    <div class="search-group">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari catatan..." autocomplete="off">
    </div>
    <button type="submit" class="btn btn-outline-primary">
        <i class="bi bi-search me-1"></i>Cari
    </button>
    @if(request('search'))
        <a href="{{ route('catatan.index') }}" class="btn-reset"><i class="bi bi-x-lg"></i>Reset</a>
    @endif
</form>

<div class="row g-3">
    @forelse($catatan as $item)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="dashboard-card h-100 d-flex flex-column" style="padding:18px">
                <div class="d-flex justify-content-between align-items-start mb-2 gap-2">
                    <h6 style="font-weight:700;color:var(--text);font-size:14px;margin:0;flex:1;min-width:0">
                        {{ $item->judul }}
                    </h6>
                    <span style="font-size:11px;color:var(--text-muted);white-space:nowrap;flex-shrink:0">
                        {{ $item->created_at->diffForHumans() }}
                    </span>
                </div>
                <p class="flex-grow-1" style="color:var(--text-muted);font-size:13px;line-height:1.6;white-space:pre-wrap;margin-bottom:14px">
                    {{ \Illuminate\Support\Str::limit($item->isi, 120) }}
                </p>
                <div class="d-flex gap-2 mt-auto">
                    <a href="{{ route('catatan.show', $item) }}" class="btn btn-outline-primary btn-sm flex-fill" style="font-size:12px">
                        <i class="bi bi-eye me-1"></i>Lihat
                    </a>
                    <a href="{{ route('catatan.edit', $item) }}" class="btn btn-outline-secondary btn-sm flex-fill" style="font-size:12px">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <form action="{{ route('catatan.destroy', $item) }}" method="POST"
                          onsubmit="return confirm('Hapus catatan ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm" style="font-size:12px" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="dashboard-card">
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="bi bi-sticky"></i></div>
                    @if(request('search'))
                        <h5>Tidak ada hasil</h5>
                        <p>Tidak ada catatan yang cocok dengan pencarian.</p>
                        <a href="{{ route('catatan.index') }}" class="btn btn-outline-primary btn-sm mt-2">Reset Pencarian</a>
                    @else
                        <h5>Belum ada catatan</h5>
                        <p>Mulai catat materi perkuliahan kamu.</p>
                        <a href="{{ route('catatan.create') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-plus-lg me-1"></i>Tambah Catatan
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endforelse
</div>

@if($catatan->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $catatan->links('pagination::bootstrap-5') }}
    </div>
@endif

@endsection
