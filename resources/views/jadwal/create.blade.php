@extends('layouts.app')

@section('title', 'Tambah Jadwal')

@section('content')

<div class="page-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2>Tambah Jadwal</h2>
            <p>Tambahkan mata kuliah baru ke jadwal kamu</p>
        </div>
        <a href="{{ route('jadwal.index') }}" class="btn btn-outline-secondary">
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

    <form action="{{ route('jadwal.store') }}" method="POST" class="form-styled">
        @csrf

        <div class="mb-3">
            <label class="form-label">Mata Kuliah <span style="color:var(--danger)">*</span></label>
            <input type="text" name="mata_kuliah"
                   class="form-control @error('mata_kuliah') is-invalid @enderror"
                   value="{{ old('mata_kuliah') }}" placeholder="Contoh: Pemrograman Web" autofocus>
            @error('mata_kuliah')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Dosen</label>
            <input type="text" name="dosen"
                   class="form-control @error('dosen') is-invalid @enderror"
                   value="{{ old('dosen') }}" placeholder="Nama dosen pengampu">
            @error('dosen')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Ruangan</label>
            <input type="text" name="ruangan"
                   class="form-control @error('ruangan') is-invalid @enderror"
                   value="{{ old('ruangan') }}" placeholder="Contoh: Lab A1 / Gedung B">
            @error('ruangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Hari <span style="color:var(--danger)">*</span></label>
            <select name="hari" class="form-select @error('hari') is-invalid @enderror">
                <option value="">— Pilih Hari —</option>
                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                    <option value="{{ $hari }}" {{ old('hari') == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                @endforeach
            </select>
            @error('hari')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6">
                <label class="form-label">Jam Mulai <span style="color:var(--danger)">*</span></label>
                <input type="time" name="jam_mulai"
                       class="form-control @error('jam_mulai') is-invalid @enderror"
                       value="{{ old('jam_mulai') }}">
                @error('jam_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-6">
                <label class="form-label">Jam Selesai <span style="color:var(--danger)">*</span></label>
                <input type="time" name="jam_selesai"
                       class="form-control @error('jam_selesai') is-invalid @enderror"
                       value="{{ old('jam_selesai') }}">
                @error('jam_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100" style="padding:11px">
            <i class="bi bi-save me-2"></i>Simpan Jadwal
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
    .form-styled .form-control::placeholder { color: var(--text-muted); opacity: 0.5; }
    .form-styled .is-invalid { border-color: var(--danger) !important; }
    .form-styled .invalid-feedback { font-size: 12px; color: var(--danger); margin-top: 4px; }
</style>
@endsection
