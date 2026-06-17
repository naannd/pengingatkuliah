<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function index(Request $request)
    {
        $tugasIds = Tugas::where('user_id', Auth::id())->pluck('id');

        $query = Reminder::whereIn('tugas_id', $tugasIds)->with('tugas');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('tugas', function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%');
            });
        }

        $reminder = $query->orderBy('reminder_date', 'asc')->paginate(10)->withQueryString();

        return view('reminder.index', compact('reminder'));
    }

    public function create()
    {
        $tugas = Tugas::where('user_id', Auth::id())->orderBy('judul')->get();

        return view('reminder.create', compact('tugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tugas_id'      => 'required|exists:tugas,id',
            'reminder_date' => 'required|date',
            'status'        => 'required|in:Aktif,Nonaktif',
        ]);

        $tugas = Tugas::findOrFail($request->tugas_id);
        abort_if((int)$tugas->user_id !== (int)Auth::id(), 403);

        Reminder::create([
            'tugas_id'      => $request->tugas_id,
            'reminder_date' => $request->reminder_date,
            'status'        => $request->status,
        ]);

        return redirect()->route('reminder.index')->with('success', 'Reminder berhasil ditambahkan.');
    }

    public function edit(Reminder $reminder)
    {
        abort_if((int)$reminder->tugas->user_id !== (int)Auth::id(), 403);

        $tugas = Tugas::where('user_id', Auth::id())->orderBy('judul')->get();

        return view('reminder.edit', compact('reminder', 'tugas'));
    }

    public function update(Request $request, Reminder $reminder)
    {
        abort_if((int)$reminder->tugas->user_id !== (int)Auth::id(), 403);

        $request->validate([
            'tugas_id'      => 'required|exists:tugas,id',
            'reminder_date' => 'required|date',
            'status'        => 'required|in:Aktif,Nonaktif',
        ]);

        $tugas = Tugas::findOrFail($request->tugas_id);
        abort_if((int)$tugas->user_id !== (int)Auth::id(), 403);

        $reminder->update($request->only(['tugas_id', 'reminder_date', 'status']));

        return redirect()->route('reminder.index')->with('success', 'Reminder berhasil diperbarui.');
    }

    public function destroy(Reminder $reminder)
    {
        abort_if((int)$reminder->tugas->user_id !== (int)Auth::id(), 403);

        $reminder->delete();

        return redirect()->route('reminder.index')->with('success', 'Reminder berhasil dihapus.');
    }
}
