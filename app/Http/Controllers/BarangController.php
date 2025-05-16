<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangStoreRequest;
use App\Http\Requests\BarangUpdateRequest;
use App\Models\Barang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangController extends Controller
{
    public function index(Request $request): View
    {
        $barangs = Barang::all();

        return view('barang.index', [
            'barangs' => $barangs,
        ]);
    }

    public function create(Request $request): View
    {
        return view('barang.create');
    }

    public function store(BarangStoreRequest $request): RedirectResponse
    {
        $barang = Barang::create($request->validated());

        $request->session()->flash('barang.id', $barang->id);

        return redirect()->route('barangs.index');
    }

    public function show(Request $request, Barang $barang): View
    {
        return view('barang.show', [
            'barang' => $barang,
        ]);
    }

    public function edit(Request $request, Barang $barang): View
    {
        return view('barang.edit', [
            'barang' => $barang,
        ]);
    }

    public function update(BarangUpdateRequest $request, Barang $barang): RedirectResponse
    {
        $barang->update($request->validated());

        $request->session()->flash('barang.id', $barang->id);

        return redirect()->route('barangs.index');
    }

    public function destroy(Request $request, Barang $barang): RedirectResponse
    {
        $barang->delete();

        return redirect()->route('barangs.index');
    }
}
