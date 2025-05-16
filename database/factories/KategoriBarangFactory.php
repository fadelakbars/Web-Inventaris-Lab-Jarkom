<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\KategoriBarang;

class KategoriBarangFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = KategoriBarang::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama_kategori' => fake()->regexify('[A-Za-z0-9]{100}'),
            'deskripsi' => fake()->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
