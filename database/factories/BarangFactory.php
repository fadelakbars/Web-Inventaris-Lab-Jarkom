<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Barang;
use App\Models\KategoriBarang;

class BarangFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Barang::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama_barang' => fake()->regexify('[A-Za-z0-9]{150}'),
            'kode_barang' => fake()->regexify('[A-Za-z0-9]{100}'),
            'kategori_id' => KategoriBarang::factory(),
            'jumlah' => fake()->numberBetween(-10000, 10000),
            'satuan' => fake()->regexify('[A-Za-z0-9]{50}'),
            'kondisi' => fake()->randomElement(["baik","rusak","hilang"]),
            'lokasi' => fake()->regexify('[A-Za-z0-9]{100}'),
        ];
    }
}
