<x-guest-layout>

    <h2>Selamat Datang Kembali</h2>
    <p class="auth-subtitle">Masuk ke akun PengingatKuliah kamu</p>

    @if(session('status'))
        <div class="auth-alert auth-alert-success">
            <i class="bi bi-check-circle me-1"></i>{{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="auth-alert auth-alert-danger">
            <i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="bi bi-envelope"></i></span>
                <input id="email" type="email" name="email" class="form-control"
                       value="{{ old('email') }}" required autofocus
                       autocomplete="username" placeholder="nama@universitas.ac.id">
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="bi bi-lock"></i></span>
                <input id="password" type="password" name="password" class="form-control"
                       required autocomplete="current-password" placeholder="Masukkan password">
                <button type="button" class="toggle-password"><i class="bi bi-eye"></i></button>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                <label for="remember_me" class="form-check-label">Ingat saya</label>
            </div>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">Lupa password?</a>
            @endif
        </div>

        <button type="submit" class="btn-auth">
            <i class="bi bi-box-arrow-in-right"></i> Masuk
        </button>

        <hr class="auth-divider">
        <p class="text-center mb-0" style="color:var(--text-muted);font-size:14px">
            Belum punya akun?
            <a href="{{ route('register') }}" class="auth-link">Daftar sekarang</a>
        </p>
    </form>

</x-guest-layout>
