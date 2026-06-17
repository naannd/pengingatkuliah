<?php

namespace App\Http\Controllers;

use App\Models\Catatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Catatan::where('user_id', Auth::id());

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->input('search') . '%');
        }

        $catatan = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        return view('catatan.index', compact('catatan'));
    }

    public function create()
    {
        return view('catatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:200',
            'isi'   => 'required|string',
        ]);

        Catatan::create([
            'user_id' => Auth::id(),
            'judul'   => $request->judul,
            'isi'     => $request->isi,
        ]);

        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil ditambahkan.');
    }

    public function show(Catatan $catatan)
    {
        abort_if((int)$catatan->user_id !== (int)Auth::id(), 403);

        return view('catatan.show', compact('catatan'));
    }

    public function edit(Catatan $catatan)
    {
        abort_if((int)$catatan->user_id !== (int)Auth::id(), 403);

        return view('catatan.edit', compact('catatan'));
    }

    public function update(Request $request, Catatan $catatan)
    {
        abort_if((int)$catatan->user_id !== (int)Auth::id(), 403);

        $request->validate([
            'judul' => 'required|string|max:200',
            'isi'   => 'required|string',
        ]);

        $catatan->update($request->only(['judul', 'isi']));

        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil diperbarui.');
    }

    public function destroy(Catatan $catatan)
    {
        abort_if((int)$catatan->user_id !== (int)Auth::id(), 403);

        $catatan->delete();

        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil dihapus.');
    }
}
