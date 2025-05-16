<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengembalianStoreRequest;
use App\Http\Requests\PengembalianUpdateRequest;
use App\Models\Pengembalian;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengembalianController extends Controller
{
    public function index(Request $request): View
    {
        $pengembalians = Pengembalian::all();

        return view('pengembalian.index', [
            'pengembalians' => $pengembalians,
        ]);
    }

    public function create(Request $request): View
    {
        return view('pengembalian.create');
    }

    public function store(PengembalianStoreRequest $request): RedirectResponse
    {
        $pengembalian = Pengembalian::create($request->validated());

        $request->session()->flash('pengembalian.id', $pengembalian->id);

        return redirect()->route('pengembalians.index');
    }

    public function show(Request $request, Pengembalian $pengembalian): View
    {
        return view('pengembalian.show', [
            'pengembalian' => $pengembalian,
        ]);
    }

    public function edit(Request $request, Pengembalian $pengembalian): View
    {
        return view('pengembalian.edit', [
            'pengembalian' => $pengembalian,
        ]);
    }

    public function update(PengembalianUpdateRequest $request, Pengembalian $pengembalian): RedirectResponse
    {
        $pengembalian->update($request->validated());

        $request->session()->flash('pengembalian.id', $pengembalian->id);

        return redirect()->route('pengembalians.index');
    }

    public function destroy(Request $request, Pengembalian $pengembalian): RedirectResponse
    {
        $pengembalian->delete();

        return redirect()->route('pengembalians.index');
    }
}
