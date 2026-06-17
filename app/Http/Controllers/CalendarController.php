<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Tugas;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Map Indonesian day names to FullCalendar daysOfWeek (0=Sun … 6=Sat).
     */
    private const DAY_MAP = [
        'Minggu' => 0,
        'Senin'  => 1,
        'Selasa' => 2,
        'Rabu'   => 3,
        'Kamis'  => 4,
        'Jumat'  => 5,
        'Sabtu'  => 6,
    ];

    /**
     * Show the calendar page.
     */
    public function index()
    {
        return view('calendar.index');
    }

    /**
     * Return calendar events as JSON for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function events(\Illuminate\Http\Request $request): JsonResponse
    {
        $userId = Auth::id();
        $events = [];

        // ── Jadwal → recurring weekly events (Orange) ──────────────
        $jadwals = Jadwal::where('user_id', $userId)->get();

        foreach ($jadwals as $j) {
            $dayOfWeek = self::DAY_MAP[$j->hari] ?? null;

            if ($dayOfWeek === null) {
                continue; // skip unknown day names
            }

            $events[] = [
                'id'              => 'jadwal-' . $j->id,
                'title'           => $j->mata_kuliah,
                'startRecur'      => '2000-01-01',
                'endRecur'        => '2099-12-31',
                'daysOfWeek'      => [$dayOfWeek],
                'startTime'       => $j->jam_mulai,
                'endTime'         => $j->jam_selesai,
                'backgroundColor' => '#F97316',
                'borderColor'     => '#EA580C',
                'extendedProps'   => [
                    'type'        => 'Jadwal Kuliah',
                    'dosen'       => $j->dosen,
                    'ruangan'     => $j->ruangan,
                    'hari'        => $j->hari,
                    'jam_mulai'   => $j->jam_mulai,
                    'jam_selesai' => $j->jam_selesai,
                ],
            ];
        }

        // ── Tugas → deadline events (Red) ─────────────────────────
        $tugasList = Tugas::where('user_id', $userId)->whereNotNull('deadline')->get();

        foreach ($tugasList as $t) {
            $events[] = [
                'id'              => 'tugas-' . $t->id,
                'title'           => $t->judul,
                'start'           => $t->deadline->toIso8601String(),
                'allDay'          => true,
                'backgroundColor' => '#EF4444',
                'borderColor'     => '#DC2626',
                'extendedProps'   => [
                    'type'      => 'Tugas',
                    'deskripsi' => $t->deskripsi,
                    'deadline'  => $t->deadline->format('d M Y H:i'),
                    'progress'  => $t->progress . '%',
                    'status'    => $t->status,
                ],
            ];
        }

        // ── Reminder → reminder events (Yellow) ───────────────────
        // Reminder belongs to Tugas; only fetch reminders for this user's tugas.
        $tugasIds    = $tugasList->pluck('id');
        $reminders   = Reminder::whereIn('tugas_id', $tugasIds)
            ->whereNotNull('reminder_date')
            ->with('tugas')
            ->get();

        foreach ($reminders as $r) {
            $events[] = [
                'id'              => 'reminder-' . $r->id,
                'title'           => 'Reminder: ' . ($r->tugas->judul ?? 'Tugas'),
                'start'           => Carbon::parse($r->reminder_date)->toIso8601String(),
                'allDay'          => true,
                'backgroundColor' => '#F59E0B',
                'borderColor'     => '#D97706',
                'textColor'       => '#000000',
                'extendedProps'   => [
                    'type'          => 'Reminder',
                    'tugas'         => $r->tugas->judul ?? '-',
                    'reminder_date' => Carbon::parse($r->reminder_date)->format('d M Y H:i'),
                    'status'        => $r->status,
                ],
            ];
        }

        return response()->json($events);
    }
}
