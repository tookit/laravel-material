<?php
namespace Modules\Mall\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Mall\Models\ItemDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->word(),
            'package' => $this->faker->sentence(),
            'after_service' => $this->faker->sentence(),
        ];
    }
}

