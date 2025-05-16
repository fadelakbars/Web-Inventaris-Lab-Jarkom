<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Barang;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;

class DetailPeminjamanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DetailPeminjaman::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'peminjaman_id' => Peminjaman::factory(),
            'barang_id' => Barang::factory(),
            'jumlah_pinjam' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
