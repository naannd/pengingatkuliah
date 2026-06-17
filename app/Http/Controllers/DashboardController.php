<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Tugas;
use App\Models\Catatan;
use App\Models\Reminder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $today  = Carbon::today();
        $hari   = $today->locale('id')->isoFormat('dddd');

        $jadwalHariIni = Jadwal::where('user_id', $userId)
            ->where('hari', ucfirst($hari))
            ->orderBy('jam_mulai')
            ->get();

        $tugasMendatang = Tugas::where('user_id', $userId)
            ->where('status', '!=', 'Selesai')
            ->orderBy('deadline', 'asc')
            ->take(5)
            ->get();

        $tugasIds = Tugas::where('user_id', $userId)->pluck('id');

        $reminderAktif = Reminder::whereIn('tugas_id', $tugasIds)
            ->where('status', 'Aktif')
            ->where('reminder_date', '>=', $today)
            ->orderBy('reminder_date')
            ->take(5)
            ->get();

        $catatanTerbaru = Catatan::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $totalJadwal   = Jadwal::where('user_id', $userId)->count();
        $totalTugas    = Tugas::where('user_id', $userId)->count();
        $tugasSelesai  = Tugas::where('user_id', $userId)->where('status', 'Selesai')->count();
        $totalCatatan  = Catatan::where('user_id', $userId)->count();
        $totalReminder = Reminder::whereIn('tugas_id', $tugasIds)->where('status', 'Aktif')->count();

        return view('dashboard', compact(
            'jadwalHariIni',
            'tugasMendatang',
            'reminderAktif',
            'catatanTerbaru',
            'totalJadwal',
            'totalTugas',
            'tugasSelesai',
            'totalCatatan',
            'totalReminder'
        ));
    }

    /**
     * Return chart data as JSON for the authenticated user.
     */
    public function chartData(): JsonResponse
    {
        $userId   = Auth::id();
        $tugasIds = Tugas::where('user_id', $userId)->pluck('id');

        // ── Pie: completed vs incomplete tasks ────────────────────
        $tugasSelesai = Tugas::where('user_id', $userId)->where('status', 'Selesai')->count();
        $tugasBelum   = Tugas::where('user_id', $userId)->where('status', '!=', 'Selesai')->count();

        // ── Bar: tasks per month (current year, by created_at) ────
        $year = now()->year;

        $tugasPerMonth = Tugas::where('user_id', $userId)
            ->whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'month');

        $tugasMonthly = [];
        for ($m = 1; $m <= 12; $m++) {
            $tugasMonthly[] = (int) ($tugasPerMonth[$m] ?? 0);
        }

        // ── Bar: reminders per month (current year, by reminder_date) ──
        $reminderPerMonth = Reminder::whereIn('tugas_id', $tugasIds)
            ->whereYear('reminder_date', $year)
            ->selectRaw('MONTH(reminder_date) as month, COUNT(*) as total')
            ->groupByRaw('MONTH(reminder_date)')
            ->pluck('total', 'month');

        $reminderMonthly = [];
        for ($m = 1; $m <= 12; $m++) {
            $reminderMonthly[] = (int) ($reminderPerMonth[$m] ?? 0);
        }

        return response()->json([
            'pie' => [
                'completed'  => $tugasSelesai,
                'incomplete' => $tugasBelum,
            ],
            'tugasMonthly'    => $tugasMonthly,
            'reminderMonthly' => $reminderMonthly,
            'monthLabels'     => ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            'year'            => $year,
        ]);
    }
}
