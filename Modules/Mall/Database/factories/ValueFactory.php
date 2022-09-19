<?php
namespace Modules\Mall\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Mall\Models\Value::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->faker->word(),
        ];
    }
}

