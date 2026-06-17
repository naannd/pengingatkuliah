@extends('layouts.app')

@section('title', 'Profil Saya')

@section('styles')
<style>
    .profile-avatar-img {
        width: 96px; height: 96px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary);
        box-shadow: 0 4px 16px rgba(37,99,235,0.2);
    }
    .profile-avatar-placeholder {
        width: 96px; height: 96px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--orange));
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 32px; font-weight: 800;
        border: 3px solid var(--primary);
        box-shadow: 0 4px 16px rgba(37,99,235,0.2);
        flex-shrink: 0;
    }
    .info-row { display: flex; flex-direction: column; gap: 2px; margin-bottom: 14px; }
    .info-label { font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.4px; }
    .info-value { font-size: 14px; font-weight: 600; color: var(--text); }

    .profile-form label {
        font-size: 12px; font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase; letter-spacing: 0.3px;
        margin-bottom: 5px; display: block;
    }
    .profile-form .form-control,
    .profile-form .form-select {
        background: var(--input-bg);
        border: 1.5px solid var(--border);
        color: var(--text);
        border-radius: 9px;
        padding: 9px 13px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.2s ease;
        width: 100%;
    }
    .profile-form .form-control:focus,
    .profile-form .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(96,165,250,0.15);
        background: var(--input-focus-bg); outline: none; color: var(--text);
    }
    .profile-form .form-control::placeholder { color: var(--text-muted); opacity: 0.5; }
    .profile-form .form-control[readonly],
    .profile-form .form-control:disabled {
        background: var(--bg);
        color: var(--text-muted);
        opacity: 0.7;
    }

    .section-header {
        display: flex; align-items: center; gap: 8px;
        font-size: 14px; font-weight: 700; color: var(--text);
        margin-bottom: 18px; padding-bottom: 12px;
        border-bottom: 1px solid var(--border);
    }
    .section-header i { color: var(--primary); font-size: 16px; }
</style>
@endsection

@section('content')

<div class="page-header">
    <h2>Profil Saya</h2>
    <p>Kelola informasi akun dan data akademik kamu</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any() && !$errors->updatePassword->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $err)<li style="font-size:13px">{{ $err }}</li>@endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->updatePassword->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4">
        <ul class="mb-0 ps-3">
            @foreach($errors->updatePassword->all() as $err)<li style="font-size:13px">{{ $err }}</li>@endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">

    {{-- LEFT: Profile Card --}}
    <div class="col-12 col-lg-4">
        <div class="dashboard-card text-center" style="padding:28px 20px">
            {{-- Avatar --}}
            <div class="mb-3 d-flex justify-content-center">
                @if($user->photo)
                    <img src="{{ Storage::url($user->photo) }}" alt="Foto Profil"
                         class="profile-avatar-img" id="avatarPreview">
                @else
                    <div class="profile-avatar-placeholder" id="avatarPlaceholder">
                        {{ strtoupper(substr($user->nama ?? '?', 0, 2)) }}
                    </div>
                @endif
            </div>

            <h5 style="font-weight:800;color:var(--text);margin-bottom:4px;font-size:17px">{{ $user->nama }}</h5>
            <p style="color:var(--text-muted);font-size:13px;margin-bottom:4px">{{ $user->email }}</p>
            <p style="color:var(--primary);font-size:13px;font-weight:600;margin-bottom:18px">
                <i class="bi bi-building me-1"></i>{{ $user->universitas ?? 'Universitas tidak diset' }}
            </p>

            <hr style="border-color:var(--border);margin:0 0 18px">

            <div class="text-start">
                <div class="info-row">
                    <span class="info-label">Program Studi</span>
                    <span class="info-value">{{ $user->prodi ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Semester</span>
                    <span class="info-value">{{ $user->semester ? 'Semester ' . $user->semester : '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">NIM</span>
                    <span class="info-value">{{ $user->nim ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Angkatan</span>
                    <span class="info-value">{{ $user->angkatan ?? '—' }}</span>
                </div>
                <div class="info-row" style="margin-bottom:0">
                    <span class="info-label">Bergabung</span>
                    <span class="info-value">{{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '—' }}</span>
                </div>
            </div>
        </div>

        {{-- Academic progress card --}}
        @if($totalTugas > 0)
        <div class="dashboard-card mt-3" style="padding:18px">
            <div style="font-size:13px;font-weight:700;color:var(--text);margin-bottom:12px">
                <i class="bi bi-graph-up me-2" style="color:var(--orange)"></i>Progress Akademik
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span style="font-size:12px;color:var(--text-muted)">Tugas Selesai</span>
                <span style="font-size:12px;font-weight:700;color:var(--orange)">{{ $progress }}%</span>
            </div>
            <div class="progress-track" style="height:8px">
                <div class="progress-fill" style="width:{{ $progress }}%"></div>
            </div>
            <div style="font-size:11px;color:var(--text-muted);margin-top:8px">
                {{ $tugasSelesai }} dari {{ $totalTugas }} tugas diselesaikan
            </div>
        </div>
        @endif
    </div>

    {{-- RIGHT: Forms --}}
    <div class="col-12 col-lg-8">

        {{-- Stats --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4">
                <div class="stat-card">
                    <div class="stat-card-inner">
                        <div class="stat-card-info">
                            <div class="stat-label">Jadwal</div>
                            <div class="stat-value">{{ $totalJadwal }}</div>
                        </div>
                        <div class="stat-icon-wrap stat-blue"><i class="bi bi-calendar-week"></i></div>
                    </div>
                    <div class="stat-accent-line" style="background:linear-gradient(90deg,#2563EB,#60A5FA)"></div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="stat-card">
                    <div class="stat-card-inner">
                        <div class="stat-card-info">
                            <div class="stat-label">Total Tugas</div>
                            <div class="stat-value">{{ $totalTugas }}</div>
                        </div>
                        <div class="stat-icon-wrap stat-orange"><i class="bi bi-journal-check"></i></div>
                    </div>
                    <div class="stat-accent-line" style="background:linear-gradient(90deg,#F97316,#FB923C)"></div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="stat-card">
                    <div class="stat-card-inner">
                        <div class="stat-card-info">
                            <div class="stat-label">Selesai</div>
                            <div class="stat-value">{{ $tugasSelesai }}</div>
                        </div>
                        <div class="stat-icon-wrap stat-green"><i class="bi bi-check-circle"></i></div>
                    </div>
                    <div class="stat-accent-line" style="background:linear-gradient(90deg,#22C55E,#4ADE80)"></div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="stat-card">
                    <div class="stat-card-inner">
                        <div class="stat-card-info">
                            <div class="stat-label">Catatan</div>
                            <div class="stat-value">{{ $totalCatatan }}</div>
                        </div>
                        <div class="stat-icon-wrap stat-purple"><i class="bi bi-sticky"></i></div>
                    </div>
                    <div class="stat-accent-line" style="background:linear-gradient(90deg,#7C3AED,#A78BFA)"></div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="stat-card">
                    <div class="stat-card-inner">
                        <div class="stat-card-info">
                            <div class="stat-label">Reminder</div>
                            <div class="stat-value">{{ $totalReminder }}</div>
                        </div>
                        <div class="stat-icon-wrap stat-red"><i class="bi bi-bell"></i></div>
                    </div>
                    <div class="stat-accent-line" style="background:linear-gradient(90deg,#EF4444,#F87171)"></div>
                </div>
            </div>
        </div>

        {{-- Profile Info Form --}}
        <form action="{{ route('profile.update') }}" method="POST"
              enctype="multipart/form-data" class="profile-form">
            @csrf @method('PATCH')

            <div class="dashboard-card mb-4">
                <div class="section-header">
                    <i class="bi bi-person-vcard"></i> Informasi Pribadi
                </div>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control"
                               value="{{ old('nama', $user->nama) }}" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label>Universitas</label>
                        <input type="text" name="universitas" class="form-control"
                               value="{{ old('universitas', $user->universitas) }}"
                               placeholder="Nama universitas kamu">
                    </div>
                    <div class="col-12 col-md-6">
                        <label>Foto Profil</label>
                        <input type="file" name="photo" class="form-control"
                               accept="image/jpeg,image/png,image/webp" id="photoInput">
                        <div style="font-size:11px;color:var(--text-muted);margin-top:4px">
                            JPG / PNG / WebP, maks 2 MB
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-card mb-4">
                <div class="section-header">
                    <i class="bi bi-mortarboard"></i> Informasi Akademik
                </div>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label>Program Studi</label>
                        <input type="text" name="prodi" class="form-control"
                               value="{{ old('prodi', $user->prodi) }}"
                               placeholder="Contoh: Teknik Informatika">
                    </div>
                    <div class="col-6 col-md-3">
                        <label>Semester</label>
                        <select name="semester" class="form-select">
                            <option value="">Pilih</option>
                            @for($s = 1; $s <= 14; $s++)
                                <option value="{{ $s }}" @selected(old('semester', $user->semester) == $s)>{{ $s }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <label>Angkatan</label>
                        <input type="number" name="angkatan" class="form-control"
                               value="{{ old('angkatan', $user->angkatan) }}"
                               min="2000" max="{{ now()->year + 1 }}" placeholder="2023">
                    </div>
                    <div class="col-12 col-md-6">
                        <label>NIM</label>
                        <input type="text" name="nim" class="form-control"
                               value="{{ old('nim', $user->nim) }}"
                               placeholder="Contoh: 2023001001" maxlength="30">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>

        {{-- Password Form --}}
        <div class="dashboard-card">
            <div class="section-header">
                <i class="bi bi-shield-lock"></i> Keamanan Akun
            </div>
            <form action="{{ route('profile.password') }}" method="POST" class="profile-form">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-12">
                        <label>Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control"
                               autocomplete="current-password" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label>Password Baru</label>
                        <input type="password" name="password" class="form-control"
                               autocomplete="new-password" required minlength="8">
                    </div>
                    <div class="col-12 col-md-6">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control"
                               autocomplete="new-password" required>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-key me-1"></i>Ubah Password
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('photoInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(ev) {
            const placeholder = document.getElementById('avatarPlaceholder');
            const existing = document.getElementById('avatarPreview');
            if (placeholder) {
                const img = document.createElement('img');
                img.src = ev.target.result;
                img.className = 'profile-avatar-img';
                img.id = 'avatarPreview';
                placeholder.replaceWith(img);
            } else if (existing) {
                existing.src = ev.target.result;
            }
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection
