@extends('layouts.app')

@section('title', 'Tambah Reminder')

@section('content')

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2>Tambah Reminder</h2>
            <p>Atur pengingat untuk deadline tugas kamu</p>
        </div>
        <a href="{{ route('reminder.index') }}" class="btn btn-outline-secondary">
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

    <form action="{{ route('reminder.store') }}" method="POST" class="form-styled">
        @csrf

        <div class="mb-3">
            <label>Tugas <span style="color:var(--danger)">*</span></label>
            <select name="tugas_id" class="form-select @error('tugas_id') is-invalid @enderror">
                <option value="">— Pilih Tugas —</option>
                @foreach($tugas as $t)
                    <option value="{{ $t->id }}" {{ old('tugas_id') == $t->id ? 'selected' : '' }}>
                        {{ $t->judul }}
                    </option>
                @endforeach
            </select>
            @error('tugas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label>Tanggal & Waktu Reminder <span style="color:var(--danger)">*</span></label>
            <input type="datetime-local" name="reminder_date"
                   class="form-control @error('reminder_date') is-invalid @enderror"
                   value="{{ old('reminder_date') }}">
            @error('reminder_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label>Status <span style="color:var(--danger)">*</span></label>
            <select name="status" class="form-select @error('status') is-invalid @enderror">
                <option value="">— Pilih Status —</option>
                <option value="Aktif"    {{ old('status') == 'Aktif'    ? 'selected' : '' }}>Aktif</option>
                <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-primary w-100" style="padding:11px">
            <i class="bi bi-save me-2"></i>Simpan Reminder
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
        transition: all 0.2s; width: 100%;
    }
    .form-styled .form-control::placeholder { color: var(--text-muted); opacity: 0.5; }
    .form-styled .form-control:focus,
    .form-styled .form-select:focus {
        border-color: var(--primary); box-shadow: 0 0 0 3px rgba(96,165,250,0.15);
        background: var(--input-focus-bg); outline: none; color: var(--text);
    }
    .form-styled .is-invalid { border-color: var(--danger) !important; }
    .form-styled .invalid-feedback { font-size: 12px; color: var(--danger); margin-top: 4px; display:block; }
</style>
@endsection
