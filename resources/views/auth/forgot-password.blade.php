<x-guest-layout>

    <h2>Lupa Password?</h2>
    <p class="auth-subtitle">Masukkan email kamu dan kami akan mengirimkan link untuk mereset password.</p>

    {{-- Session Status --}}
    @if(session('status'))
        <div class="alert auth-alert auth-alert-success mb-3">
            <i class="bi bi-check-circle me-1"></i>{{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <div class="input-wrap">
                <span class="input-icon"><i class="bi bi-envelope"></i></span>
                <input id="email" type="email" name="email" class="form-control"
                       value="{{ old('email') }}" required autofocus
                       placeholder="nama@universitas.ac.id">
            </div>
            @error('email')
                <div class="text-danger" style="font-size:12px;margin-top:4px">{{ $message }}</div>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-auth mb-3">
            <i class="bi bi-envelope-paper me-2"></i>Kirim Link Reset
        </button>

        {{-- Back to login --}}
        <hr class="auth-divider">
        <p class="text-center mb-0" style="color:var(--text-muted);font-size:14px">
            <a href="{{ route('login') }}" class="auth-link"><i class="bi bi-arrow-left me-1"></i>Kembali ke halaman login</a>
        </p>
    </form>

</x-guest-layout>
