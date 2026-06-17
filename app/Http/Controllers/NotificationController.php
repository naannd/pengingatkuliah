<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Tugas;
use App\Models\Reminder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Return academic notifications as JSON.
     */
    public function index(): JsonResponse
    {
        $userId  = Auth::id();
        $now     = Carbon::now();
        $today   = Carbon::today();
        $hari    = $today->locale('id')->isoFormat('dddd');
        $threeDays = $today->copy()->addDays(3)->endOfDay();

        $notifications = collect();

        // ── 1. Upcoming Deadlines (within 3 days, not completed) ──────────
        $tugasMendatang = Tugas::where('user_id', $userId)
            ->where('status', '!=', 'Selesai')
            ->where('deadline', '>=', $now)
            ->where('deadline', '<=', $threeDays)
            ->orderBy('deadline', 'asc')
            ->get();

        foreach ($tugasMendatang as $tugas) {
            $deadline = Carbon::parse($tugas->deadline);

            if ($deadline->isToday()) {
                $priority = 'urgent';
                $color    = '#EF4444';
                $icon     = 'bi-exclamation-circle-fill';
                $label    = 'Deadline Hari Ini';
            } elseif ($deadline->isTomorrow()) {
                $priority = 'warning';
                $color    = '#F97316';
                $icon     = 'bi-clock-fill';
                $label    = 'Deadline Besok';
            } else {
                $priority = 'info';
                $color    = '#FACC15';
                $icon     = 'bi-hourglass-split';
                $daysLeft = $today->diffInDays($deadline);
                $label    = "Deadline {$daysLeft} Hari Lagi";
            }

            $notifications->push([
                'type'     => 'deadline',
                'priority' => $priority,
                'icon'     => $icon,
                'color'    => $color,
                'label'    => $label,
                'title'    => $tugas->judul,
                'message'  => $tugas->judul . ' — ' . $deadline->format('H:i'),
                'time'     => $deadline->toIso8601String(),
                'time_ago' => $now->diffForHumans($deadline, ['syntax' => Carbon::DIFF_RELATIVE_TO_NOW]),
                'url'      => route('tugas.edit', $tugas->id),
                'sort_key' => $deadline->timestamp,
            ]);
        }

        // ── 2. Today's Class Schedule ─────────────────────────────────────
        $jadwalHariIni = Jadwal::where('user_id', $userId)
            ->where('hari', ucfirst($hari))
            ->orderBy('jam_mulai')
            ->get();

        foreach ($jadwalHariIni as $jadwal) {
            $notifications->push([
                'type'     => 'jadwal',
                'priority' => 'info',
                'icon'     => 'bi-book-fill',
                'color'    => '#3B82F6',
                'label'    => 'Jadwal Hari Ini',
                'title'    => $jadwal->mata_kuliah,
                'message'  => $jadwal->mata_kuliah . ' pukul ' . substr($jadwal->jam_mulai, 0, 5) . ' - ' . substr($jadwal->jam_selesai, 0, 5),
                'time'     => $today->copy()->setTimeFromTimeString($jadwal->jam_mulai)->toIso8601String(),
                'time_ago' => 'Hari ini ' . substr($jadwal->jam_mulai, 0, 5),
                'url'      => route('jadwal.index'),
                'sort_key' => $today->copy()->setTimeFromTimeString($jadwal->jam_mulai)->timestamp,
            ]);
        }

        // ── 3. Active Reminders ───────────────────────────────────────────
        $tugasIds = Tugas::where('user_id', $userId)->pluck('id');

        $reminderAktif = Reminder::whereIn('tugas_id', $tugasIds)
            ->where('status', 'Aktif')
            ->where('reminder_date', '>=', $now)
            ->with('tugas')
            ->orderBy('reminder_date')
            ->take(10)
            ->get();

        foreach ($reminderAktif as $reminder) {
            $rDate = Carbon::parse($reminder->reminder_date);

            $notifications->push([
                'type'     => 'reminder',
                'priority' => 'info',
                'icon'     => 'bi-bell-fill',
                'color'    => '#8B5CF6',
                'label'    => 'Reminder Aktif',
                'title'    => $reminder->tugas->judul ?? 'Reminder',
                'message'  => ($reminder->tugas->judul ?? 'Reminder') . ' — ' . $rDate->translatedFormat('d M Y') . ' ' . $rDate->format('H:i'),
                'time'     => $rDate->toIso8601String(),
                'time_ago' => $now->diffForHumans($rDate, ['syntax' => Carbon::DIFF_RELATIVE_TO_NOW]),
                'url'      => route('reminder.index'),
                'sort_key' => $rDate->timestamp,
            ]);
        }

        // ── Sort by time ascending, then return ───────────────────────────
        $sorted = $notifications->sortBy('sort_key')->values();

        return response()->json([
            'count'         => $sorted->count(),
            'notifications' => $sorted->take(15)->values(),
            'latest_five'   => $sorted->take(5)->values(),
            'has_jadwal'    => $jadwalHariIni->isNotEmpty(),
        ]);
    }
}
