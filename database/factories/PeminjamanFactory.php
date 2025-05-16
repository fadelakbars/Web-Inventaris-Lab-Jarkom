<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Peminjaman;
use App\Models\User;

class PeminjamanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Peminjaman::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'tanggal_pinjam' => fake()->date(),
            'tanggal_kembali' => fake()->date(),
            'status' => fake()->randomElement(["dipinjam","dikembalikan","terlambat"]),
            'keterangan' => fake()->text(),
        ];
    }
}
