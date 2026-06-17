@extends('layouts.app')

@section('title', 'Detail Catatan')

@section('content')

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2>Detail Catatan</h2>
            <p>Dibuat {{ $catatan->created_at->translatedFormat('d F Y, H:i') }}</p>
        </div>
        <a href="{{ route('catatan.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="dashboard-card" style="max-width:720px">
    <div class="d-flex justify-content-between align-items-start mb-4 gap-3">
        <h4 style="font-weight:800;color:var(--text);font-size:20px;letter-spacing:-0.3px;margin:0;flex:1">
            {{ $catatan->judul }}
        </h4>
        <span style="font-size:12px;color:var(--text-muted);white-space:nowrap;flex-shrink:0;padding-top:4px">
            <i class="bi bi-clock me-1"></i>{{ $catatan->updated_at->diffForHumans() }}
        </span>
    </div>

    <hr style="border-color:var(--border);margin-bottom:20px">

    <div style="color:var(--text);white-space:pre-wrap;line-height:1.85;font-size:14.5px">{{ $catatan->isi }}</div>

    <hr style="border-color:var(--border);margin-top:24px;margin-bottom:18px">

    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('catatan.edit', $catatan) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i>Edit Catatan
        </a>
        <form action="{{ route('catatan.destroy', $catatan) }}" method="POST"
              onsubmit="return confirm('Hapus catatan ini?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger">
                <i class="bi bi-trash me-1"></i>Hapus
            </button>
        </form>
    </div>
</div>

@endsection
