<?php

namespace App\Http\Controllers;

use App\Models\Catatan;
use App\Models\Jadwal;
use App\Models\Reminder;
use App\Models\Tugas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile dashboard.
     */
    public function edit(Request $request): View
    {
        $user   = $request->user();
        $userId = $user->id;

        // ── Statistics ─────────────────────────────────────────────
        $totalJadwal  = Jadwal::where('user_id', $userId)->count();
        $totalTugas   = Tugas::where('user_id', $userId)->count();
        $tugasSelesai = Tugas::where('user_id', $userId)->where('status', 'Selesai')->count();
        $totalCatatan = Catatan::where('user_id', $userId)->count();

        $tugasIds      = Tugas::where('user_id', $userId)->pluck('id');
        $totalReminder = Reminder::whereIn('tugas_id', $tugasIds)->count();

        $progress = $totalTugas > 0 ? round(($tugasSelesai / $totalTugas) * 100) : 0;

        return view('profile.edit', compact(
            'user',
            'totalJadwal',
            'totalTugas',
            'tugasSelesai',
            'totalCatatan',
            'totalReminder',
            'progress'
        ));
    }

    /**
     * Update personal + academic info and/or photo.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            // Personal
            'nama'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'universitas' => ['nullable', 'string', 'max:255'],
            // Academic
            'prodi'       => ['nullable', 'string', 'max:100'],
            'semester'    => ['nullable', 'integer', 'min:1', 'max:14'],
            'nim'         => ['nullable', 'string', 'max:30', Rule::unique('users')->ignore($user->id)],
            'angkatan'    => ['nullable', 'integer', 'min:2000', 'max:' . (now()->year + 1)],
            // Photo
            'photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('profile_photos', 'public');
        }

        // Reset email verification if email changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->fill($validated);
        $user->save();

        return Redirect::route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return Redirect::route('profile.edit')
            ->with('success', 'Password berhasil diubah.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
