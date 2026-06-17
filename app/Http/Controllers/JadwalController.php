<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        $query = Jadwal::where('user_id', Auth::id());

        if ($request->filled('search')) {
            $query->where('mata_kuliah', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('hari') && in_array($request->input('hari'), $hariList, true)) {
            $query->where('hari', $request->input('hari'));
        }

        $jadwal = $query
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('jam_mulai')
            ->paginate(10)
            ->withQueryString();

        return view('jadwal.index', compact('jadwal', 'hariList'));
    }

    public function create()
    {
        return view('jadwal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_kuliah' => 'required|string|max:100',
            'dosen'       => 'required|string|max:100',
            'ruangan'     => 'required|string|max:50',
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        Jadwal::create([
            'user_id'     => Auth::id(),
            'mata_kuliah' => $request->mata_kuliah,
            'dosen'       => $request->dosen,
            'ruangan'     => $request->ruangan,
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Jadwal $jadwal)
    {
        abort_if((int)$jadwal->user_id !== (int)Auth::id(), 403);

        return view('jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        abort_if((int)$jadwal->user_id !== (int)Auth::id(), 403);

        $request->validate([
            'mata_kuliah' => 'required|string|max:100',
            'dosen'       => 'required|string|max:100',
            'ruangan'     => 'required|string|max:50',
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $jadwal->update($request->only([
            'mata_kuliah', 'dosen', 'ruangan', 'hari', 'jam_mulai', 'jam_selesai',
        ]));

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal)
    {
        abort_if((int)$jadwal->user_id !== (int)Auth::id(), 403);

        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * Export Jadwal to PDF.
     */
    public function exportPdf()
    {
        $user = Auth::user();

        $jadwal = Jadwal::where('user_id', $user->id)
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')")
            ->orderBy('jam_mulai')
            ->get();

        $pdf = Pdf::loadView('pdf.jadwal', [
            'jadwal'  => $jadwal,
            'user'    => $user,
            'tanggal' => Carbon::now()->locale('id')->isoFormat('D MMMM YYYY'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('jadwal-kuliah.pdf');
    }
}
