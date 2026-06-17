@extends('layouts.app')

@section('title', 'Tambah Catatan')

@section('content')

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2>Tambah Catatan</h2>
            <p>Catat materi atau hal penting dari perkuliahan</p>
        </div>
        <a href="{{ route('catatan.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="dashboard-card" style="max-width:700px">

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li style="font-size:13px">{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('catatan.store') }}" method="POST" class="form-styled">
        @csrf

        <div class="mb-3">
            <label>Judul Catatan <span style="color:var(--danger)">*</span></label>
            <input type="text" name="judul"
                   class="form-control @error('judul') is-invalid @enderror"
                   value="{{ old('judul') }}"
                   placeholder="Contoh: Rangkuman Pertemuan 5 — Basis Data" autofocus>
            @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label>Isi Catatan <span style="color:var(--danger)">*</span></label>
            <textarea name="isi" rows="10"
                      class="form-control @error('isi') is-invalid @enderror"
                      placeholder="Tulis catatanmu di sini...">{{ old('isi') }}</textarea>
            @error('isi')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary w-100" style="padding:11px">
            <i class="bi bi-save me-2"></i>Simpan Catatan
        </button>
    </form>
</div>

@endsection

@section('page-styles')
<style>
    .form-styled label { font-size:12px; font-weight:600; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.3px; margin-bottom:5px; display:block; }
    .form-styled .form-control {
        background: var(--input-bg); border: 1.5px solid var(--border);
        color: var(--text); border-radius: 9px;
        padding: 10px 13px; font-size: 14px; font-family: inherit;
        transition: all 0.2s; width: 100%; resize: vertical;
    }
    .form-styled .form-control:focus {
        border-color: var(--primary); box-shadow: 0 0 0 3px rgba(96,165,250,0.15);
        background: var(--input-focus-bg); outline: none; color: var(--text);
    }
    .form-styled .form-control::placeholder { color: var(--text-muted); opacity: 0.5; }
    .form-styled .is-invalid { border-color: var(--danger) !important; }
    .form-styled .invalid-feedback { font-size: 12px; color: var(--danger); margin-top: 4px; display:block; }
</style>
@endsection
