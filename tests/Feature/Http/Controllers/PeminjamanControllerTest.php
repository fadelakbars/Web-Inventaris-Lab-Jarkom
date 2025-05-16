<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PeminjamanController
 */
final class PeminjamanControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $peminjamen = Peminjaman::factory()->count(3)->create();

        $response = $this->get(route('peminjamen.index'));

        $response->assertOk();
        $response->assertViewIs('peminjaman.index');
        $response->assertViewHas('peminjamen');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('peminjamen.create'));

        $response->assertOk();
        $response->assertViewIs('peminjaman.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PeminjamanController::class,
            'store',
            \App\Http\Requests\PeminjamanStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $user = User::factory()->create();
        $tanggal_pinjam = Carbon::parse(fake()->date());
        $tanggal_kembali = Carbon::parse(fake()->date());
        $status = fake()->randomElement(/** enum_attributes **/);

        $response = $this->post(route('peminjamen.store'), [
            'user_id' => $user->id,
            'tanggal_pinjam' => $tanggal_pinjam->toDateString(),
            'tanggal_kembali' => $tanggal_kembali->toDateString(),
            'status' => $status,
        ]);

        $peminjamen = Peminjaman::query()
            ->where('user_id', $user->id)
            ->where('tanggal_pinjam', $tanggal_pinjam)
            ->where('tanggal_kembali', $tanggal_kembali)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $peminjamen);
        $peminjaman = $peminjamen->first();

        $response->assertRedirect(route('peminjamen.index'));
        $response->assertSessionHas('peminjaman.id', $peminjaman->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $peminjaman = Peminjaman::factory()->create();

        $response = $this->get(route('peminjamen.show', $peminjaman));

        $response->assertOk();
        $response->assertViewIs('peminjaman.show');
        $response->assertViewHas('peminjaman');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $peminjaman = Peminjaman::factory()->create();

        $response = $this->get(route('peminjamen.edit', $peminjaman));

        $response->assertOk();
        $response->assertViewIs('peminjaman.edit');
        $response->assertViewHas('peminjaman');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PeminjamanController::class,
            'update',
            \App\Http\Requests\PeminjamanUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $peminjaman = Peminjaman::factory()->create();
        $user = User::factory()->create();
        $tanggal_pinjam = Carbon::parse(fake()->date());
        $tanggal_kembali = Carbon::parse(fake()->date());
        $status = fake()->randomElement(/** enum_attributes **/);

        $response = $this->put(route('peminjamen.update', $peminjaman), [
            'user_id' => $user->id,
            'tanggal_pinjam' => $tanggal_pinjam->toDateString(),
            'tanggal_kembali' => $tanggal_kembali->toDateString(),
            'status' => $status,
        ]);

        $peminjaman->refresh();

        $response->assertRedirect(route('peminjamen.index'));
        $response->assertSessionHas('peminjaman.id', $peminjaman->id);

        $this->assertEquals($user->id, $peminjaman->user_id);
        $this->assertEquals($tanggal_pinjam, $peminjaman->tanggal_pinjam);
        $this->assertEquals($tanggal_kembali, $peminjaman->tanggal_kembali);
        $this->assertEquals($status, $peminjaman->status);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $peminjaman = Peminjaman::factory()->create();

        $response = $this->delete(route('peminjamen.destroy', $peminjaman));

        $response->assertRedirect(route('peminjamen.index'));

        $this->assertModelMissing($peminjaman);
    }
}
