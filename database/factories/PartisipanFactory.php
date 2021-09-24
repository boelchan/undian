<?php

namespace Database\Factories;

use App\Models\Partisipan;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartisipanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Partisipan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nik' => Str::random(10),
            'nama' => $this->faker->name(),
            'alamat' => 'sumenep',
        ];
    }
}
