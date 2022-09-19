<?php
namespace Modules\PMS\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\PMS\Enum\TaskStatus;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\PMS\Models\Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'project_id' => $this->faker->randomDigit,
            'description' => $this->faker->sentence(),
            'status' => TaskStatus::getRandomValue(),
        ];
    }
}

