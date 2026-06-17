<x-guest-layout>

    <h2>Konfirmasi Password</h2>
    <p class="auth-subtitle">Ini adalah area aman. Silakan konfirmasi password kamu sebelum melanjutkan.</p>

    <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
        @csrf

        {{-- Password --}}
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-icon"><i class="bi bi-lock"></i></span>
                <input id="password" type="password" name="password" class="form-control"
                       required autocomplete="current-password" placeholder="Masukkan password">
                <button type="button" class="toggle-password"><i class="bi bi-eye"></i></button>
            </div>
            @error('password')
                <div class="text-danger" style="font-size:12px;margin-top:4px">{{ $message }}</div>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-auth">
            <i class="bi bi-check-circle me-2"></i>Konfirmasi
        </button>
    </form>

</x-guest-layout>
