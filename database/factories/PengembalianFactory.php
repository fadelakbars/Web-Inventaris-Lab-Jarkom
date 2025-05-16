<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class PengembalianFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pengembalian::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'peminjaman_id' => Peminjaman::factory(),
            'tanggal_pengembalian' => fake()->date(),
            'kondisi_barang' => fake()->randomElement(["baik","rusak","hilang"]),
            'catatan' => fake()->text(),
        ];
    }
}
