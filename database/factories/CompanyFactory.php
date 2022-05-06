<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
use Faker\Provider\fa_IR\PhoneNumber;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{

    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = FakerFactory::create();

        return [
            'name' => $faker->company(),
            'website' => $faker->url(),
            'phone' => PhoneNumber::mobileNumber(),
            'address' => $faker->address(),
            'description' => null
        ];
    }
}
