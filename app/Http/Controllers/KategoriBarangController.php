<?php

namespace App\Http\Controllers;

use App\Http\Requests\KategoriBarangStoreRequest;
use App\Http\Requests\KategoriBarangUpdateRequest;
use App\Models\KategoriBarang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriBarangController extends Controller
{
    public function index(Request $request): View
    {
        $kategoriBarangs = KategoriBarang::all();

        return view('kategoriBarang.index', [
            'kategoriBarangs' => $kategoriBarangs,
        ]);
    }

    public function create(Request $request): View
    {
        return view('kategoriBarang.create');
    }

    public function store(KategoriBarangStoreRequest $request): RedirectResponse
    {
        $kategoriBarang = KategoriBarang::create($request->validated());

        $request->session()->flash('kategoriBarang.id', $kategoriBarang->id);

        return redirect()->route('kategoriBarangs.index');
    }

    public function show(Request $request, KategoriBarang $kategoriBarang): View
    {
        return view('kategoriBarang.show', [
            'kategoriBarang' => $kategoriBarang,
        ]);
    }

    public function edit(Request $request, KategoriBarang $kategoriBarang): View
    {
        return view('kategoriBarang.edit', [
            'kategoriBarang' => $kategoriBarang,
        ]);
    }

    public function update(KategoriBarangUpdateRequest $request, KategoriBarang $kategoriBarang): RedirectResponse
    {
        $kategoriBarang->update($request->validated());

        $request->session()->flash('kategoriBarang.id', $kategoriBarang->id);

        return redirect()->route('kategoriBarangs.index');
    }

    public function destroy(Request $request, KategoriBarang $kategoriBarang): RedirectResponse
    {
        $kategoriBarang->delete();

        return redirect()->route('kategoriBarangs.index');
    }
}
