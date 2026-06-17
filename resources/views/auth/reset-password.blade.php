<x-guest-layout>

    <h2>Reset Password</h2>
    <p class="auth-subtitle">Buat password baru untuk akun kamu.</p>

    <form method="POST" action="{{ route('password.store') }}" class="auth-form">
        @csrf

        {{-- Token --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
                <span class="input-icon"><i class="bi bi-envelope"></i></span>
                <input id="email" type="email" name="email" class="form-control"
                       value="{{ old('email', $request->email) }}" required autofocus
                       autocomplete="username">
            </div>
            @error('email')
                <div class="text-danger" style="font-size:12px;margin-top:4px">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password Baru</label>
            <div class="input-group">
                <span class="input-icon"><i class="bi bi-lock"></i></span>
                <input id="password" type="password" name="password" class="form-control"
                       required autocomplete="new-password" placeholder="Minimal 8 karakter">
                <button type="button" class="toggle-password"><i class="bi bi-eye"></i></button>
            </div>
            @error('password')
                <div class="text-danger" style="font-size:12px;margin-top:4px">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-group">
                <span class="input-icon"><i class="bi bi-lock-fill"></i></span>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control"
                       required autocomplete="new-password" placeholder="Ulangi password">
                <button type="button" class="toggle-password"><i class="bi bi-eye"></i></button>
            </div>
            @error('password_confirmation')
                <div class="text-danger" style="font-size:12px;margin-top:4px">{{ $message }}</div>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-auth">
            <i class="bi bi-check-circle me-2"></i>Reset Password
        </button>
    </form>

</x-guest-layout>
