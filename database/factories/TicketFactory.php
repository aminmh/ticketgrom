<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{

    protected $model = \App\Models\Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'text' => $this->faker->text(),
            'subject' => $this->faker->title(),
            'user_id' => 1,
            'cc' => $this->faker->email(),
            'bcc' => $this->faker->email(),
            'department_id' => 1,
            'status' => 1,
            'inbox_id' => 1,
            'priority' => 'hight'
        ];
    }
}
