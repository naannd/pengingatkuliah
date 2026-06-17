<x-guest-layout>

    <h2>Buat Akun Baru</h2>
    <p class="auth-subtitle">Daftar untuk mulai mengelola akademik kamu</p>

    @if($errors->any())
        <div class="auth-alert auth-alert-danger">
            <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="bi bi-person"></i></span>
                <input id="nama" type="text" name="nama" class="form-control"
                       value="{{ old('nama') }}" required autofocus
                       placeholder="Nama lengkap kamu">
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="bi bi-envelope"></i></span>
                <input id="email" type="email" name="email" class="form-control"
                       value="{{ old('email') }}" required
                       placeholder="nama@universitas.ac.id">
            </div>
        </div>

        <div class="mb-3">
            <label for="universitas" class="form-label">Universitas</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="bi bi-building"></i></span>
                <input id="universitas" type="text" name="universitas" class="form-control"
                       value="{{ old('universitas') }}" required
                       placeholder="Nama universitas kamu">
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="bi bi-lock"></i></span>
                <input id="password" type="password" name="password" class="form-control"
                       required autocomplete="new-password" placeholder="Minimal 8 karakter">
                <button type="button" class="toggle-password"><i class="bi bi-eye"></i></button>
            </div>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="bi bi-lock-fill"></i></span>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control"
                       required autocomplete="new-password" placeholder="Ulangi password">
                <button type="button" class="toggle-password"><i class="bi bi-eye"></i></button>
            </div>
        </div>

        <button type="submit" class="btn-auth">
            <i class="bi bi-person-plus"></i> Daftar Sekarang
        </button>

        <hr class="auth-divider">
        <p class="text-center mb-0" style="color:var(--text-muted);font-size:14px">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a>
        </p>
    </form>

</x-guest-layout>
