<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\KategoriBarangController
 */
final class KategoriBarangControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $kategoriBarangs = KategoriBarang::factory()->count(3)->create();

        $response = $this->get(route('kategori-barangs.index'));

        $response->assertOk();
        $response->assertViewIs('kategoriBarang.index');
        $response->assertViewHas('kategoriBarangs');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('kategori-barangs.create'));

        $response->assertOk();
        $response->assertViewIs('kategoriBarang.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\KategoriBarangController::class,
            'store',
            \App\Http\Requests\KategoriBarangStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nama_kategori = fake()->word();

        $response = $this->post(route('kategori-barangs.store'), [
            'nama_kategori' => $nama_kategori,
        ]);

        $kategoriBarangs = KategoriBarang::query()
            ->where('nama_kategori', $nama_kategori)
            ->get();
        $this->assertCount(1, $kategoriBarangs);
        $kategoriBarang = $kategoriBarangs->first();

        $response->assertRedirect(route('kategoriBarangs.index'));
        $response->assertSessionHas('kategoriBarang.id', $kategoriBarang->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $kategoriBarang = KategoriBarang::factory()->create();

        $response = $this->get(route('kategori-barangs.show', $kategoriBarang));

        $response->assertOk();
        $response->assertViewIs('kategoriBarang.show');
        $response->assertViewHas('kategoriBarang');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $kategoriBarang = KategoriBarang::factory()->create();

        $response = $this->get(route('kategori-barangs.edit', $kategoriBarang));

        $response->assertOk();
        $response->assertViewIs('kategoriBarang.edit');
        $response->assertViewHas('kategoriBarang');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\KategoriBarangController::class,
            'update',
            \App\Http\Requests\KategoriBarangUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $kategoriBarang = KategoriBarang::factory()->create();
        $nama_kategori = fake()->word();

        $response = $this->put(route('kategori-barangs.update', $kategoriBarang), [
            'nama_kategori' => $nama_kategori,
        ]);

        $kategoriBarang->refresh();

        $response->assertRedirect(route('kategoriBarangs.index'));
        $response->assertSessionHas('kategoriBarang.id', $kategoriBarang->id);

        $this->assertEquals($nama_kategori, $kategoriBarang->nama_kategori);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $kategoriBarang = KategoriBarang::factory()->create();

        $response = $this->delete(route('kategori-barangs.destroy', $kategoriBarang));

        $response->assertRedirect(route('kategoriBarangs.index'));

        $this->assertModelMissing($kategoriBarang);
    }
}
