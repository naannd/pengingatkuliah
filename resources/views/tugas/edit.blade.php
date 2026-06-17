@extends('layouts.app')

@section('title', 'Edit Tugas')

@section('content')

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2>Edit Tugas</h2>
            <p>Perbarui informasi tugas kamu</p>
        </div>
        <a href="{{ route('tugas.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
</div>

<div class="dashboard-card" style="max-width:660px">

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

    <form action="{{ route('tugas.update', $tugas) }}" method="POST" class="form-styled">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Judul Tugas <span style="color:var(--danger)">*</span></label>
            <input type="text" name="judul"
                   class="form-control @error('judul') is-invalid @enderror"
                   value="{{ old('judul', $tugas->judul) }}">
            @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label>Deskripsi <span style="color:var(--text-muted);font-weight:400;text-transform:none;letter-spacing:0">(opsional)</span></label>
            <textarea name="deskripsi" rows="3"
                      class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $tugas->deskripsi) }}</textarea>
            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label>Deadline <span style="color:var(--danger)">*</span></label>
            <input type="datetime-local" name="deadline"
                   class="form-control @error('deadline') is-invalid @enderror"
                   value="{{ old('deadline', \Carbon\Carbon::parse($tugas->deadline)->format('Y-m-d\TH:i')) }}">
            @error('deadline')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label>Progress: <span id="progressVal" style="color:var(--orange);font-weight:700">{{ old('progress', $tugas->progress) }}%</span></label>
            <input type="range" name="progress" min="0" max="100"
                   value="{{ old('progress', $tugas->progress) }}"
                   class="form-range"
                   style="accent-color:var(--orange)"
                   oninput="document.getElementById('progressVal').textContent = this.value + '%'">
        </div>

        <div class="mb-4">
            <label>Status <span style="color:var(--danger)">*</span></label>
            <select name="status" class="form-select @error('status') is-invalid @enderror">
                <option value="Belum Selesai" {{ old('status', $tugas->status) == 'Belum Selesai' ? 'selected' : '' }}>Belum Selesai</option>
                <option value="Selesai"       {{ old('status', $tugas->status) == 'Selesai'       ? 'selected' : '' }}>Selesai</option>
            </select>
            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary w-100" style="padding:11px">
            <i class="bi bi-save me-2"></i>Update Tugas
        </button>
    </form>
</div>

@endsection

@section('page-styles')
<style>
    .form-styled label { font-size:12px; font-weight:600; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.3px; margin-bottom:5px; display:block; }
    .form-styled .form-control,
    .form-styled .form-select {
        background: var(--input-bg); border: 1.5px solid var(--border);
        color: var(--text); border-radius: 9px;
        padding: 10px 13px; font-size: 14px; font-family: inherit;
        transition: all 0.2s; width: 100%; resize: vertical;
    }
    .form-styled .form-control:focus,
    .form-styled .form-select:focus {
        border-color: var(--primary); box-shadow: 0 0 0 3px rgba(96,165,250,0.15);
        background: var(--input-focus-bg); outline: none; color: var(--text);
    }
    .form-styled .form-control::placeholder { color: var(--text-muted); opacity: 0.5; }
    .form-styled .is-invalid { border-color: var(--danger) !important; }
    .form-styled .invalid-feedback { font-size: 12px; color: var(--danger); margin-top: 4px; display:block; }
</style>
@endsection
