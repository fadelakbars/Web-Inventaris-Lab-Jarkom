<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeminjamanStoreRequest;
use App\Http\Requests\PeminjamanUpdateRequest;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function index(Request $request): View
    {
        $peminjamen = Peminjaman::all();

        return view('peminjaman.index', [
            'peminjamen' => $peminjamen,
        ]);
    }

    public function create(Request $request): View
    {
        return view('peminjaman.create');
    }

    public function store(PeminjamanStoreRequest $request): RedirectResponse
    {
        $peminjaman = Peminjaman::create($request->validated());

        $request->session()->flash('peminjaman.id', $peminjaman->id);

        return redirect()->route('peminjamen.index');
    }

    public function show(Request $request, Peminjaman $peminjaman): View
    {
        return view('peminjaman.show', [
            'peminjaman' => $peminjaman,
        ]);
    }

    public function edit(Request $request, Peminjaman $peminjaman): View
    {
        return view('peminjaman.edit', [
            'peminjaman' => $peminjaman,
        ]);
    }

    public function update(PeminjamanUpdateRequest $request, Peminjaman $peminjaman): RedirectResponse
    {
        $peminjaman->update($request->validated());

        $request->session()->flash('peminjaman.id', $peminjaman->id);

        return redirect()->route('peminjamen.index');
    }

    public function destroy(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        $peminjaman->delete();

        return redirect()->route('peminjamen.index');
    }
}
