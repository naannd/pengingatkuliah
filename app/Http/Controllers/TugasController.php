<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Stats are always computed from the full (unfiltered) dataset.
        $allUserTugas = Tugas::where('user_id', $userId)->get();
        $totalTugas   = $allUserTugas->count();
        $selesai      = $allUserTugas->where('status', 'Selesai')->count();
        $belumSelesai = $allUserTugas->where('status', 'Belum Selesai')->count();
        $terlambat    = $allUserTugas->filter(fn($t) => $t->isOverdue())->count();

        // Build filtered / paginated listing.
        $query = Tugas::where('user_id', $userId);

        if ($search = $request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->input('status') === 'Selesai') {
            $query->where('status', 'Selesai');
        } elseif ($request->input('status') === 'Belum Selesai') {
            $query->where('status', 'Belum Selesai');
        }

        $tugas = $query->orderBy('deadline', 'asc')->paginate(10)->withQueryString();

        return view('tugas.index', compact(
            'tugas', 'totalTugas', 'selesai', 'belumSelesai', 'terlambat'
        ));
    }

    public function create()
    {
        return view('tugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'deadline'  => 'required|date',
            'progress'  => 'nullable|integer|min:0|max:100',
            'status'    => 'required|in:Belum Selesai,Selesai',
        ]);

        Tugas::create([
            'user_id'   => Auth::id(),
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline'  => $request->deadline,
            'progress'  => $request->progress ?? 0,
            'status'    => $request->status,
        ]);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function edit(Tugas $tugas)
    {
        abort_if((int)$tugas->user_id !== (int)Auth::id(), 403);

        return view('tugas.edit', compact('tugas'));
    }

    public function update(Request $request, Tugas $tugas)
    {
        abort_if((int)$tugas->user_id !== (int)Auth::id(), 403);

        $request->validate([
            'judul'     => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'deadline'  => 'required|date',
            'progress'  => 'nullable|integer|min:0|max:100',
            'status'    => 'required|in:Belum Selesai,Selesai',
        ]);

        $tugas->update([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline'  => $request->deadline,
            'progress'  => $request->progress ?? 0,
            'status'    => $request->status,
        ]);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Tugas $tugas)
    {
        abort_if((int)$tugas->user_id !== (int)Auth::id(), 403);

        $tugas->delete();

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus.');
    }

    public function complete(Tugas $tugas)
    {
        abort_if((int)$tugas->user_id !== (int)Auth::id(), 403);

        $tugas->update([
            'status'   => 'Selesai',
            'progress' => 100,
        ]);

        return redirect()->route('tugas.index')->with('success', 'Tugas ditandai selesai.');
    }

    /**
     * Export Tugas to PDF.
     */
    public function exportPdf()
    {
        $user = Auth::user();

        $tugas = Tugas::where('user_id', $user->id)
            ->orderBy('deadline', 'asc')
            ->get();

        $pdf = Pdf::loadView('pdf.tugas', [
            'tugas'   => $tugas,
            'user'    => $user,
            'tanggal' => Carbon::now()->locale('id')->isoFormat('D MMMM YYYY'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('daftar-tugas.pdf');
    }
}
