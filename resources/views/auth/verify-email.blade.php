<x-guest-layout>

    <h2>Verifikasi Email</h2>
    <p class="auth-subtitle">
        Terima kasih sudah mendaftar! Silakan verifikasi email kamu dengan mengklik link yang telah kami kirimkan.
    </p>

    @if(session('status') == 'verification-link-sent')
        <div class="alert auth-alert auth-alert-success mb-3">
            <i class="bi bi-check-circle me-1"></i>Link verifikasi baru telah dikirim ke email kamu.
        </div>
    @endif

    <div class="auth-form">
        <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
            @csrf
            <button type="submit" class="btn btn-auth">
                <i class="bi bi-envelope me-2"></i>Kirim Ulang Email Verifikasi
            </button>
        </form>

        <hr class="auth-divider">

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="btn btn-link auth-link">
                <i class="bi bi-box-arrow-left me-1"></i>Keluar
            </button>
        </form>
    </div>

</x-guest-layout>
