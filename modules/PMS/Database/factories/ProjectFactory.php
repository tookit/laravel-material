<?php
namespace Modules\PMS\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\PMS\Enum\ProjectStatus;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\PMS\Models\Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(ProjectStatus::getValues())
        ];
    }
}

