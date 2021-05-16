<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $username = $this->faker->username;
        return [
            'username' => $username,
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'gender' => $this->faker->randomElement(User::GENDER),
            'flag' => $this->faker->randomElement(User::getFlags()),
            'avatar' => sprintf("https://ui-avatars.com/api/?name=%s",$username),
            'email_verified_at' => now(),
            'password' => 'password', // password
            'remember_token' => Str::random(10),
        ];
    }
}
