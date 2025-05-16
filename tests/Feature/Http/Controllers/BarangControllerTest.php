<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\BarangController
 */
final class BarangControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $barangs = Barang::factory()->count(3)->create();

        $response = $this->get(route('barangs.index'));

        $response->assertOk();
        $response->assertViewIs('barang.index');
        $response->assertViewHas('barangs');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('barangs.create'));

        $response->assertOk();
        $response->assertViewIs('barang.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BarangController::class,
            'store',
            \App\Http\Requests\BarangStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $nama_barang = fake()->word();
        $kode_barang = fake()->word();
        $kategori = Kategori::factory()->create();
        $jumlah = fake()->numberBetween(-10000, 10000);
        $satuan = fake()->word();
        $kondisi = fake()->randomElement(/** enum_attributes **/);
        $lokasi = fake()->word();

        $response = $this->post(route('barangs.store'), [
            'nama_barang' => $nama_barang,
            'kode_barang' => $kode_barang,
            'kategori_id' => $kategori->id,
            'jumlah' => $jumlah,
            'satuan' => $satuan,
            'kondisi' => $kondisi,
            'lokasi' => $lokasi,
        ]);

        $barangs = Barang::query()
            ->where('nama_barang', $nama_barang)
            ->where('kode_barang', $kode_barang)
            ->where('kategori_id', $kategori->id)
            ->where('jumlah', $jumlah)
            ->where('satuan', $satuan)
            ->where('kondisi', $kondisi)
            ->where('lokasi', $lokasi)
            ->get();
        $this->assertCount(1, $barangs);
        $barang = $barangs->first();

        $response->assertRedirect(route('barangs.index'));
        $response->assertSessionHas('barang.id', $barang->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $barang = Barang::factory()->create();

        $response = $this->get(route('barangs.show', $barang));

        $response->assertOk();
        $response->assertViewIs('barang.show');
        $response->assertViewHas('barang');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $barang = Barang::factory()->create();

        $response = $this->get(route('barangs.edit', $barang));

        $response->assertOk();
        $response->assertViewIs('barang.edit');
        $response->assertViewHas('barang');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\BarangController::class,
            'update',
            \App\Http\Requests\BarangUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $barang = Barang::factory()->create();
        $nama_barang = fake()->word();
        $kode_barang = fake()->word();
        $kategori = Kategori::factory()->create();
        $jumlah = fake()->numberBetween(-10000, 10000);
        $satuan = fake()->word();
        $kondisi = fake()->randomElement(/** enum_attributes **/);
        $lokasi = fake()->word();

        $response = $this->put(route('barangs.update', $barang), [
            'nama_barang' => $nama_barang,
            'kode_barang' => $kode_barang,
            'kategori_id' => $kategori->id,
            'jumlah' => $jumlah,
            'satuan' => $satuan,
            'kondisi' => $kondisi,
            'lokasi' => $lokasi,
        ]);

        $barang->refresh();

        $response->assertRedirect(route('barangs.index'));
        $response->assertSessionHas('barang.id', $barang->id);

        $this->assertEquals($nama_barang, $barang->nama_barang);
        $this->assertEquals($kode_barang, $barang->kode_barang);
        $this->assertEquals($kategori->id, $barang->kategori_id);
        $this->assertEquals($jumlah, $barang->jumlah);
        $this->assertEquals($satuan, $barang->satuan);
        $this->assertEquals($kondisi, $barang->kondisi);
        $this->assertEquals($lokasi, $barang->lokasi);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $barang = Barang::factory()->create();

        $response = $this->delete(route('barangs.destroy', $barang));

        $response->assertRedirect(route('barangs.index'));

        $this->assertModelMissing($barang);
    }
}
