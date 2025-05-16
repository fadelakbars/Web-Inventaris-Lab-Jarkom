<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PengembalianController
 */
final class PengembalianControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $pengembalians = Pengembalian::factory()->count(3)->create();

        $response = $this->get(route('pengembalians.index'));

        $response->assertOk();
        $response->assertViewIs('pengembalian.index');
        $response->assertViewHas('pengembalians');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('pengembalians.create'));

        $response->assertOk();
        $response->assertViewIs('pengembalian.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PengembalianController::class,
            'store',
            \App\Http\Requests\PengembalianStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $peminjaman = Peminjaman::factory()->create();
        $tanggal_pengembalian = Carbon::parse(fake()->date());
        $kondisi_barang = fake()->randomElement(/** enum_attributes **/);

        $response = $this->post(route('pengembalians.store'), [
            'peminjaman_id' => $peminjaman->id,
            'tanggal_pengembalian' => $tanggal_pengembalian->toDateString(),
            'kondisi_barang' => $kondisi_barang,
        ]);

        $pengembalians = Pengembalian::query()
            ->where('peminjaman_id', $peminjaman->id)
            ->where('tanggal_pengembalian', $tanggal_pengembalian)
            ->where('kondisi_barang', $kondisi_barang)
            ->get();
        $this->assertCount(1, $pengembalians);
        $pengembalian = $pengembalians->first();

        $response->assertRedirect(route('pengembalians.index'));
        $response->assertSessionHas('pengembalian.id', $pengembalian->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $pengembalian = Pengembalian::factory()->create();

        $response = $this->get(route('pengembalians.show', $pengembalian));

        $response->assertOk();
        $response->assertViewIs('pengembalian.show');
        $response->assertViewHas('pengembalian');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $pengembalian = Pengembalian::factory()->create();

        $response = $this->get(route('pengembalians.edit', $pengembalian));

        $response->assertOk();
        $response->assertViewIs('pengembalian.edit');
        $response->assertViewHas('pengembalian');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PengembalianController::class,
            'update',
            \App\Http\Requests\PengembalianUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $pengembalian = Pengembalian::factory()->create();
        $peminjaman = Peminjaman::factory()->create();
        $tanggal_pengembalian = Carbon::parse(fake()->date());
        $kondisi_barang = fake()->randomElement(/** enum_attributes **/);

        $response = $this->put(route('pengembalians.update', $pengembalian), [
            'peminjaman_id' => $peminjaman->id,
            'tanggal_pengembalian' => $tanggal_pengembalian->toDateString(),
            'kondisi_barang' => $kondisi_barang,
        ]);

        $pengembalian->refresh();

        $response->assertRedirect(route('pengembalians.index'));
        $response->assertSessionHas('pengembalian.id', $pengembalian->id);

        $this->assertEquals($peminjaman->id, $pengembalian->peminjaman_id);
        $this->assertEquals($tanggal_pengembalian, $pengembalian->tanggal_pengembalian);
        $this->assertEquals($kondisi_barang, $pengembalian->kondisi_barang);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $pengembalian = Pengembalian::factory()->create();

        $response = $this->delete(route('pengembalians.destroy', $pengembalian));

        $response->assertRedirect(route('pengembalians.index'));

        $this->assertModelMissing($pengembalian);
    }
}
